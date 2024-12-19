<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameUserController extends Controller
{
    public function toggleLike(Game $game)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $user = Auth::user();

            // Verificar si el usuario ya ha dado like
            $like = $game->likes()->where('user_id', $user->id)->first();

            if ($like) {
                // Si ya dio like, eliminarlo
                $like->delete();
                return response()->json(['message' => 'Like eliminado']);
            } else {
                // Si no ha dado like, agregarlo
                $game->likes()->create(['user_id' => $user->id]);
                return response()->json(['message' => 'Like agregado']);
            }
        }

        return response()->json(['message' => 'Debes estar autenticado para dar like'], 401);
    }

    public function getLikes()
    {
        // Cargar los juegos con el conteo de likes y la relación con los likes del usuario
        $games = Game::withCount('likes') // Contamos los likes
                     ->with(['likes' => function($query) {
                         $query->where('user_id', Auth::id()); // Verificar si el usuario ha dado like
                     }])
                     ->get();

        // Añadir la propiedad 'likedByUser' a cada juego
        foreach ($games as $game) {
            $game->likedByUser = $game->likes->isNotEmpty();
        }

        return response()->json($games);
    }
}
