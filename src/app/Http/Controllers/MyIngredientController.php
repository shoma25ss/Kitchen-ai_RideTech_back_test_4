<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyIngredient;

class MyIngredientController extends Controller
{
    // マイ食材一覧
    public function index()
    {
        $myIngredients = auth()->user()->myIngredients()->get();
        return view('my-ingredients.index', compact('myIngredients'));
    }

    // マイ食材追加
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        auth()->user()->myIngredients()->create([
            'name' => $request->name,
        ]);

        return back()->with('success', '食材を追加しました！');
    }

    // マイ食材削除
    public function destroy(MyIngredient $myIngredient)
    {
        if ($myIngredient->user_id !== auth()->id()) abort(403);

        $myIngredient->delete();

        return back()->with('success', '食材を削除しました。');
    }
}
