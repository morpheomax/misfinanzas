<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class EgresoController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $egresos = Egreso::all();
        return view('egresos.index', compact('egresos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Egreso $egreso)
    {
        //
        return view('egresos.show', compact('egreso'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Egreso $egreso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Egreso $egreso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Egreso $egreso)
    {
        //
    }
}
