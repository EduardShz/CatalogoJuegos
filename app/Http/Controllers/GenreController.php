<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use Illuminate\Http\Request;
use App\Models\Genre;

// NO olvidar que todo lo que se mande al front debe de ser envíado en formato 'json'
// Para el store y update se utilizó un Request --> 'GenreRequest' para mantener el código más sencillo y limpio

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::all();
        return response()->json($genres);
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
    public function store(GenreRequest $request)
    {
        $genre = Genre::create($request->validated());

        return response()->json([
            'success' => true,
            'genre' => $genre,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genre = Genre::findOrFail($id);
        return response()->json($genre);
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
    public function update(GenreRequest $request, $id)
    {
        $genre = Genre::find($id);
        $genre->update($request->validated());

        return response()->json([
            'success' => true,
            'genre' => $genre,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Genre::destroy($id);
        return response()->json(['message' => 'Género eliminado correctamente'], 200);
    }
}
