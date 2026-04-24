<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeLike;

class RecipeLikeController extends Controller
{
    // いいねした料理一覧
    public function index()
    {
        $recipes = auth()->user()
            ->recipeLikes()
            ->with('recipe.user')
            ->latest()
            ->paginate(12);

        return view('liked-recipes.index', compact('recipes'));
    }

    // いいね・いいね解除
    public function toggle(Recipe $recipe)
    {
        $like = RecipeLike::where('user_id', auth()->id())
            ->where('recipe_id', $recipe->id)
            ->first();

        if ($like) {
            $like->delete();
            $message = 'いいねを解除しました。';
        } else {
            RecipeLike::create([
                'user_id'   => auth()->id(),
                'recipe_id' => $recipe->id,
            ]);
            $message = 'いいねしました！';
        }

        return back()->with('success', $message);
    }
}
