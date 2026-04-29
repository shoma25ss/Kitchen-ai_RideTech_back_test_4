<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    // 審査待ちレシピ一覧
    public function index(Request $request)
    {
        $recipes = Recipe::with(['user', 'likes'])
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->where('is_public', true)
            ->where('is_reviewed', false) // 審査待ちのみ
            ->latest()
            ->paginate(20);

        return view('admin.recipes.index', compact('recipes'));
    }

    // 承認
    public function approve(Recipe $recipe)
    {
        $recipe->update(['is_reviewed' => true]);
        return back()->with('success', 'レシピを承認しました！');
    }

    // 却下（非公開に戻す）
    public function reject(Recipe $recipe)
    {
        $recipe->update(['is_public' => false, 'is_reviewed' => false]);
        return back()->with('success', 'レシピを却下しました。');
    }

    // 削除
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return back()->with('success', 'レシピを削除しました。');
    }

    // 公開済みレシピ一覧
    public function published(Request $request)
    {
        $recipes = Recipe::with(['user', 'likes'])
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->where('is_public', true)
            ->where('is_reviewed', true)
            ->latest()
            ->paginate(20);

        return view('admin.recipes.published', compact('recipes'));
    }

    // 非公開に戻す
    public function unpublish(Recipe $recipe)
    {
        $recipe->update(['is_public' => false, 'is_reviewed' => false]);
        return back()->with('success', '非公開にしました。');
    }
}
