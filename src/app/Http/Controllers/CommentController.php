<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Recipe;

class CommentController extends Controller
{
    // コメント投稿
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'body' => 'required|string|max:500',
        ]);

        Comment::create([
            'user_id'   => auth()->id(),
            'recipe_id' => $recipe->id,
            'body'      => $request->body,
        ]);

        return back()->with('success', 'コメントを投稿しました！');
    }

    // コメント削除
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) abort(403);

        $comment->delete();

        return back()->with('success', 'コメントを削除しました。');
    }
}
