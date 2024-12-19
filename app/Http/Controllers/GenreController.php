<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

// NO olvidar que todo lo que se mande al front debe de ser envíado en formato 'json'
// Para el store y update se utilizó un Request --> 'GenreRequest' para mantener el código más sencillo y limpio

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $genres = Genre::query()
            ->when($request->search, function (Builder $query, string $search) {
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->get();

        return response()->json([
            'data' => $genres,
        ]);
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
    public function show(Genre $genre)
    {
        return response()->json([
            'data' => $genre,
        ]);
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
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
