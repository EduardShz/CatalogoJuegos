<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Game;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Game $game)
    {
        $comments = $game->comments()->with('user')->get();

        // Retornar los comentarios con los datos del usuario y la fecha de creación
        $formattedComments = $comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'content' => $comment->content,
                'created_at' => $comment->created_at->toFormattedDateString(), // Formatear la fecha si lo deseas
                'user' => [
                    'name' => $comment->user->name,  // Suponiendo que el usuario tiene un campo 'name'
                    'username' => $comment->user->username,  // Suponiendo que el usuario tiene un campo 'username'
                ]
            ];
        });

        return response()->json($formattedComments);
    }

    public function store(Request $request, Game $game)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment();
        $comment->game_id = $game->id;
        $comment->user_id = auth()->id(); // Asociamos el comentario con el usuario autenticado
        $comment->content = $request->content;
        $comment->save();

        return response()->json($comment, 201);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comentario eliminado con éxito.');
    }
}
