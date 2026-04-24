<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    // 公開レシピ一覧
    public function index(Request $request)
    {
        $recipes = Recipe::with(['user', 'likes'])
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->where('is_public', true)
            ->latest()
            ->paginate(20);

        return view('admin.recipes.index', compact('recipes'));
    }

    // 公開・非公開切り替え
    public function toggle(Recipe $recipe)
    {
        $recipe->update(['is_public' => !$recipe->is_public]);

        return back()->with('success', $recipe->is_public ? '公開しました。' : '非公開にしました。');
    }

    // レシピ削除
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return back()->with('success', 'レシピを削除しました。');
    }
}
