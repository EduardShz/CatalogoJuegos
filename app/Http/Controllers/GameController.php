<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Requests\GameRequest;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $games = Game::with(['platforms', 'genres'])->get();

        return response()->json([
            'data' => $games->map(function ($game) use ($user) {
                return [
                    'id' => $game->id,
                    'name' => $game->name,
                    'published_year' => $game->published_year,
                    'rating' => $game->rating,
                    'creator' => $game->creator->name,
                    'platforms' => $game->platforms->pluck('name'), // Devuelve una lista de nombres de plataformas
                    'genres' => $game->genres->pluck('name'), // Devuelve una lista de nombres de géneros
                    'likes_count' => $game->likes()->count(), // Número de likes
                    'liked_by_user' => $user ? $game->likedByUser($user->id) : false, // Si el usuario ha dado like

                ];
            })
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GameRequest $request)
    {
        $game = Game::create([
            'name' => $request->name,
            'published_year' => $request->published_year,
            'rating' => $request->rating,
            'creator_id' => $request->creator_id,
        ]);

        // Asociar plataformas y géneros
        $game->platforms()->sync($request->platform_id);
        $game->genres()->sync($request->genre_id);

        return response()->json([
            'success' => true,
            'game' => $game,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function showId(Game $game)
    {
        $game->with(['creator', 'platforms', 'genres']);

        return response()->json([
            'id' => $game->id,
            'name' => $game->name,
            'published_year' => $game->published_year,
            'rating' => $game->rating,
            'creator_id' => $game->creator->id, // Id del creador
            'platform_id' => $game->platforms->pluck('id'), // Id de las plataformas
            'genre_id' => $game->genres->pluck('id'), // Id de los géneros
        ]);
    }

    public function showName($id)
    {
        $user = Auth::user();

        $game = Game::with(['creator', 'platforms', 'genres'])->findOrFail($id);

        return response()->json([
            'id' => $game->id,
            'name' => $game->name,
            'published_year' => $game->published_year,
            'rating' => $game->rating,
            'creator' => $game->creator->name, // Nombre del creador
            'platforms' => $game->platforms->pluck('name'), // Nombres de las plataformas
            'genres' => $game->genres->pluck('name'), // Nombres de los géneros
            'liked_by_user' => $user ? $game->likedByUser($user->id) : false, // Si el usuario ha dado like
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GameRequest $request, $id)
    {
        //Log::info('Datos recibidos:', $request->all());
        $game = Game::findOrFail($id);

        // Actualizar los campos del juego
        $game->update([
            'name' => $request->name,
            'published_year' => $request->published_year,
            'rating' => $request->rating,
            'creator_id' => $request->creator_id, // Asegúrate de que esto sea un ID válido
        ]);

        // Sincronizar relaciones en tablas pivote
        $game->platforms()->sync($request->platform_id);
        $game->genres()->sync($request->genre_id);

        return response()->json(['message' => 'Juego actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
