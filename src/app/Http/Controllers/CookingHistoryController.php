<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CookingHistory;
use App\Models\Recipe;

class CookingHistoryController extends Controller
{
    // 料理履歴一覧
    public function index()
    {
        $histories = auth()->user()
            ->cookingHistories()
            ->with('recipe')
            ->latest('cooked_at')
            ->paginate(12);

        return view('histories.index', compact('histories'));
    }

    // 調理完了の記録
    public function store(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'rating'    => 'nullable|integer|min:1|max:5',
        ]);

        CookingHistory::create([
            'user_id'   => auth()->id(),
            'recipe_id' => $request->recipe_id,
            'rating'    => $request->rating,
            'cooked_at' => now(),
        ]);

        return redirect()->route('histories.index')
            ->with('success', '調理完了を記録しました！');
    }
}
