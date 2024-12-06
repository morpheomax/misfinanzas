<?php
namespace App\Http\Controllers;

use App\Models\Egreso;
use App\Models\Ingreso;
use App\Models\Meta;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener los ingresos, egresos y metas del usuario
        $ingresos = Ingreso::where('user_id', Auth::id())->sum('monto');
        $egresos = Egreso::where('user_id', Auth::id())->sum('monto');
        $metas = Meta::where('user_id', Auth::id())->sum('monto'); // Por ejemplo, una meta de monto

        // Pasar los datos a la vista
        return view('dashboard.index', compact('ingresos', 'egresos', 'metas'));
    }
}
