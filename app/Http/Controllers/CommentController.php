<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Game;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Game $game)
    {
        /*$request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $game->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);*/

        return back()->with('success', 'Comentario añadido con éxito.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comentario eliminado con éxito.');
    }
}
