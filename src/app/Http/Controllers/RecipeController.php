<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Services\GeminiService;

class RecipeController extends Controller
{
    public function __construct(private GeminiService $gemini) {}

    // トップページ
    public function index()
    {
        $recipes = Recipe::with(['user', 'likes', 'comments'])
            ->where('is_public', true)
            ->where('is_reviewed', true)
            ->latest()
            ->paginate(auth()->check() ? 12 : 6);

        return view('top', compact('recipes'));
    }


    // レシピ生成
    public function generate(Request $request)
    {
        $request->validate([
            'ingredients'  => 'required|array|min:1',
            'ingredients.*'=> 'required|string|max:50',
            'genre'        => 'nullable|string',
            'cooking_time' => 'nullable|integer',
            'calories'     => 'nullable|integer',
            'difficulty'   => 'nullable|in:easy,medium,hard',
        ]);

        $recipes = $this->gemini->generateRecipes(
            $request->ingredients,
            $request->only(['genre', 'cooking_time', 'calories', 'difficulty'])
        );

        // セッションに保存
        session(['generated_recipes' => $recipes]);

        return view('recipes.candidates', compact('recipes'));
    }

     // 調理ナビ
     public function cook(Recipe $recipe)
     {
         $recipe->load(['steps']);
         return view('recipes.cook', compact('recipe'));
     }

    // レシピ詳細
    public function show(Recipe $recipe)
    {
        $recipe->load(['user', 'ingredients', 'steps', 'likes', 'comments.user']);
        $isLiked = auth()->check()
            ? $recipe->likes->contains('user_id', auth()->id())
            : false;

        return view('recipes.show', compact('recipe', 'isLiked'));
    }

    // 公開・非公開切り替え
    public function publish(Recipe $recipe)
    {
        if ($recipe->user_id !== auth()->id()) abort(403);

        $recipe->update(['is_public' => !$recipe->is_public]);

        return back()->with('success', $recipe->is_public ? '公開しました！' : '非公開にしました。');
    }

    public function save(Request $request)
{
    $data = json_decode($request->recipe_data, true);

    $recipe = Recipe::create([
        'user_id'      => auth()->id(),
        'title'        => $data['title'],
        'description'  => $data['description'] ?? null,
        'genre'        => $data['genre'] ?? null,
        'cooking_time' => $data['cooking_time'] ?? null,
        'calories'     => $data['calories'] ?? null,
        'difficulty'   => $data['difficulty'] ?? null,
        'is_public'    => false,
    ]);

    // 食材を保存
    foreach ($data['ingredients'] ?? [] as $i => $ingredient) {
        $recipe->ingredients()->create([
            'name'       => $ingredient['name'],
            'quantity'   => $ingredient['quantity'] ?? null,
            'sort_order' => $i,
        ]);
    }

    // 手順を保存
    foreach ($data['steps'] ?? [] as $step) {
        $recipe->steps()->create([
            'step_number'   => $step['step_number'],
            'instruction'   => $step['instruction'],
            'timer_seconds' => $step['timer_seconds'] ?? null,
        ]);
    }

    return redirect()->route('recipes.cook', $recipe);
}
}