<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatorRequest;
use App\Models\Creator;
use Illuminate\Http\Request;

// NO olvidar que todo lo que se mande al front debe de ser envíado en formato 'json'
// Para el store y update se utilizó un Request --> 'CreatorRequest' para mantener el código más sencillo y limpio

class CreatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $creators = Creator::all();
        return response()->json($creators);
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
    public function store(CreatorRequest $request)
    {
        $creator = Creator::create($request->validated());

        return response()->json([
            'success' => true,
            'creator' => $creator,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $creator = Creator::findOrFail($id);
        return response()->json($creator);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreatorRequest $request, $id)
    {
        $creator = Creator::find($id);
        $creator->update($request->validated());

        return response()->json([
            'success' => true,
            'creator' => $creator,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Creator::destroy($id);
        return response()->json(['message' => 'Creador eliminado correctamente'], 200);
    }
}
