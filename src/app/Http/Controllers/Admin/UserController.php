<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // ユーザー一覧
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', '自分自身は削除できません。');
        }

        // レシピIDを取得
        $recipeIds = $user->recipes()->pluck('id');

        // レシピに紐づく全データを削除
        \App\Models\CookingHistory::whereIn('recipe_id', $recipeIds)->delete();
        \App\Models\RecipeLike::whereIn('recipe_id', $recipeIds)->delete();
        \App\Models\Comment::whereIn('recipe_id', $recipeIds)->delete();
        \App\Models\ChatLog::whereIn('recipe_id', $recipeIds)->delete();
        \App\Models\RecipeIngredient::whereIn('recipe_id', $recipeIds)->delete();
        \App\Models\RecipeStep::whereIn('recipe_id', $recipeIds)->delete();

        // ユーザーに紐づく全データを削除
        \App\Models\CookingHistory::where('user_id', $user->id)->delete();
        \App\Models\RecipeLike::where('user_id', $user->id)->delete();
        \App\Models\Comment::where('user_id', $user->id)->delete();
        \App\Models\ChatLog::where('user_id', $user->id)->delete();
        \App\Models\MyIngredient::where('user_id', $user->id)->delete();

        // レシピを削除
        $user->recipes()->forceDelete();

        // ユーザーを削除
        $user->forceDelete();

        return back()->with('success', 'ユーザーを削除しました。');
    }
}
