<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    // ... outros métodos ...

    // Método para atualizar um comentário existente
    public function update(Request $request, $commentId)
    {
        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['message' => 'Comentário não encontrado'], 404);
        }

        $comment->update([
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        // Redirecionar ou retornar uma resposta (por exemplo, exibir uma mensagem de sucesso)
    }

    // Método para deletar um comentário existente
    public function destroy($commentId)
    {
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['message' => 'Comentário não encontrado'], 404);
        }

        $comment->delete();

        // Redirecionar ou retornar uma resposta (por exemplo, exibir uma mensagem de sucesso)
    }

    // ... outros métodos ...
}
