<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use App\Models\Ingreso;
use App\Models\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $metas = Meta::where('user_id', $userId)->get();

        // Obtener años disponibles de ingresos y egresos para el usuario logueado
        $años = DB::table('ingresos')
            ->selectRaw('YEAR(fecha) as anio')
            ->where('user_id', $userId) // Filtrar por usuario
            ->groupBy('anio')
            ->union(
                DB::table('egresos')
                    ->selectRaw('YEAR(fecha) as anio')
                    ->where('user_id', $userId) // Filtrar por usuario
                    ->groupBy('anio')
            )
            ->orderBy('anio', 'desc')
            ->pluck('anio');

        // Filtros de mes y año
        $mes = $request->input('mes');
        $anio = $request->input('anio');

        // Totales generales de ingresos
        $ingresosTotales = Ingreso::where('user_id', $userId);

        if ($mes) {
            $ingresosTotales->whereMonth('fecha', $mes);
        }

        if ($anio) {
            $ingresosTotales->whereYear('fecha', $anio);
        } else {
            $ingresosTotales->whereYear('fecha', now()->year);
        }

        $ingresosTotales = $ingresosTotales->sum('monto') ?? 0;

        // Totales generales de egresos
        $egresosTotales = Egreso::where('user_id', $userId);

        if ($mes) {
            $egresosTotales->whereMonth('fecha', $mes);
        }

        if ($anio) {
            $egresosTotales->whereYear('fecha', $anio);
        } else {
            $egresosTotales->whereYear('fecha', now()->year);
        }

        $egresosTotales = $egresosTotales->sum('monto') ?? 0;

        // Calcular el saldo general (ingresos - egresos)
        $saldoGeneral = $ingresosTotales - $egresosTotales;

        // Datos del mes actual
        $ingresosMes = $this->calcularMes($userId, 'ingresos', $mes, $anio);
        $egresosMes = $this->calcularMes($userId, 'egresos', $mes, $anio);
        $saldoMes = $ingresosMes - $egresosMes;

        // Resumen mensual por año (aplicando el filtro de año)
        $resumenMensual = $this->resumenMensual($userId, $anio, $mes);

        $totalesMensuales = collect($resumenMensual);

        // Obtener la primera meta (ajustar si se permiten múltiples metas)
        $meta = Meta::where('user_id', $userId)->first(); // Ajustar si se permiten múltiples metas

        $progreso = $this->getProgresoAttribute($meta);
        // Datos de metas
        $metasTotales = Meta::where('user_id', $userId)->count();
        $metasAhorrado = Meta::where('user_id', $userId)->sum('monto_ahorrado');

        $estadoFiltro = request()->get('estado'); // Captura filtro desde la solicitud
        $query = Meta::where('user_id', $userId);

        if ($estadoFiltro) {
            $query->where('estado', $estadoFiltro); // Filtra por estado si se proporciona
        }

        $progresoMetas = $query
            ->select('nombre', 'estado', 'monto', 'monto_ahorrado', 'created_at')
            ->whereYear('fecha', $anio ?? now()->year)
            ->whereMonth('fecha', $mes ?? now()->month)
            ->paginate(4)
            ->through(function ($meta) use ($anio, $mes) { // Pasar $anio y $mes a la función
                $progreso = $meta->monto > 0 ? ($meta->monto_ahorrado / $meta->monto) * 100 : 0;
                return [
                    'nombre' => $meta->nombre,
                    'progreso' => $progreso,
                    'estado' => $meta->estado,
                    'fecha' => $meta->created_at->format('Y'),
                    'anio' => $anio, // Agregar el año
                    'mes' => $mes, // Agregar el mes
                ];
            });

        // Contar metas completadas y pendientes
        $metasCompletadas = Meta::where('user_id', $userId)->where('estado', 'completada')->count();
        $metasPendientes = $metasTotales - $metasCompletadas;

        // Ingresos y egresos por categoría (aplicando el filtro de año y mes)
        $ingresosPorCategoria = $this->totalesPorCategoria(Ingreso::class, $userId, $mes, $anio);
        $egresosPorCategoria = $this->totalesPorCategoria(Egreso::class, $userId, $mes, $anio);

        // Últimos movimientos (aplicando el filtro de año y mes)
        $ultimosIngresos = Ingreso::where('user_id', $userId)
            ->whereYear('fecha', $anio ?? now()->year)
            ->whereMonth('fecha', $mes ?? now()->month)
            ->latest()
            ->take(5)
            ->get();
        $ultimosEgresos = Egreso::where('user_id', $userId)
            ->whereYear('fecha', $anio ?? now()->year)
            ->whereMonth('fecha', $mes ?? now()->month)
            ->latest()
            ->take(5)
            ->get();

        // Años disponibles para filtro
        $aniosDisponibles = $this->obtenerAniosDisponibles($userId);

        return view('dashboard.index', compact(
            'años',
            'anio',
            'ingresosTotales',
            'egresosTotales',
            'saldoGeneral',
            'resumenMensual',
            'totalesMensuales',
            'progresoMetas',
            'ingresosMes',
            'egresosMes',
            'saldoMes',
            'metasTotales',
            'metasAhorrado',
            'metasCompletadas',
            'metasPendientes',
            'ingresosPorCategoria',
            'egresosPorCategoria',
            'ultimosIngresos',
            'ultimosEgresos',
            'aniosDisponibles'
        ));
    }
    // Calcular el progreso de la meta
    private function getProgresoAttribute($meta)
    {
        if (!$meta || $meta->monto > 0) {
            return 0;
        }
        return ($meta->monto_ahorrado / $meta->monto) * 100;

    }

    // Calcular ingresos o egresos del mes actual
    private function calcularMes($userId, $tipo, $mes = null, $anio = null)
    {
        $model = $tipo === 'ingresos' ? Ingreso::class : Egreso::class;

        return $model::where('user_id', $userId)
            ->whereMonth('fecha', $mes ?? now()->month)
            ->whereYear('fecha', $anio ?? now()->year)
            ->sum('monto');
    }

    // Resumen mensual por año
    private function resumenMensual($userId, $anio = null)
    {
        $resumen = [];
        $meses = $this->meses();

        foreach ($meses as $mes => $mesNombre) {
            $ingresosMes = Ingreso::where('user_id', $userId)
                ->whereMonth('fecha', $mes)
                ->whereYear('fecha', $anio ?? now()->year)
                ->sum('monto');

            $egresosMes = Egreso::where('user_id', $userId)
                ->whereMonth('fecha', $mes)
                ->whereYear('fecha', $anio ?? now()->year)
                ->sum('monto');

            $saldoMes = $ingresosMes - $egresosMes;

            $resumen[] = [
                'mes' => $mesNombre,
                'ingresos' => $ingresosMes,
                'egresos' => $egresosMes,
                'saldo' => $saldoMes,
            ];
        }

        return $resumen;
    }
    // Obtener totales por categorías (ingresos o egresos)
    private function totalesPorCategoria($model, $userId, $mes = null, $anio = null)
    {
        $query = $model::where('user_id', $userId);

        // Aplicar filtro de año si está definido
        if ($anio) {
            $query->whereYear('fecha', $anio);
        }

        // Aplicar filtro de mes solo si está definido
        if ($mes) {
            $query->whereMonth('fecha', $mes);
        }

        // Agrupar y calcular el total por categoría
        return $query->selectRaw('categoria, SUM(monto) as total')
            ->groupBy('categoria')
            ->get();
    }

    // Obtener años disponibles para los filtros
    private function obtenerAniosDisponibles($userId)
    {
        $aniosIngresos = Ingreso::where('user_id', $userId)
            ->selectRaw('YEAR(fecha) as anio')
            ->distinct()
            ->pluck('anio')
            ->toArray();

        $aniosEgresos = Egreso::where('user_id', $userId)
            ->selectRaw('YEAR(fecha) as anio')
            ->distinct()
            ->pluck('anio')
            ->toArray();

        return array_unique(array_merge($aniosIngresos, $aniosEgresos));
    }

    // Listado de meses
    private function meses()
    {
        return [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ];
    }

}
