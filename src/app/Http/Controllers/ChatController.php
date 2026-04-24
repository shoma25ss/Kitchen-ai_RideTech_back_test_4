<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatLog;
use App\Models\Recipe;
use App\Services\GeminiService;

class ChatController extends Controller
{
    public function __construct(private GeminiService $gemini) {}

    public function ask(Request $request)
    {
        $request->validate([
            'question'  => 'required|string|max:500',
            'recipe_id' => 'nullable|exists:recipes,id',
        ]);

        // レシピの文脈を取得
        $recipeContext = '';
        if ($request->recipe_id) {
            $recipe = Recipe::with('steps')->find($request->recipe_id);
            if ($recipe) {
                $recipeContext = "レシピ名：{$recipe->title}";
            }
        }

        // Gemini APIに質問
        $answer = $this->gemini->chat($request->question, $recipeContext);

        // ログに保存
        ChatLog::create([
            'user_id'   => auth()->id(),
            'recipe_id' => $request->recipe_id,
            'question'  => $request->question,
            'answer'    => $answer,
        ]);

        return response()->json([
            'answer' => $answer,
        ]);
    }
}
