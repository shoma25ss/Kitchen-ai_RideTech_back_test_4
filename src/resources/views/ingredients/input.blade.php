@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-700 mb-6">🥕 食材を入力してレシピ生成</h1>

    <form method="POST" action="{{ route('recipes.generate') }}">
        @csrf

        <!-- 食材入力 -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="font-bold text-gray-700 mb-3">食材を入力</h2>

            <div id="ingredient-tags" class="flex flex-wrap gap-2 mb-3">
                <!-- タグはJSで追加 -->
            </div>

            <div class="flex gap-2">
                <input type="text" id="ingredient-input"
                    placeholder="例：たまご、豚肉、玉ねぎ"
                    class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-green-500">
                <button type="button" onclick="addIngredient()"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-500">
                    追加
                </button>
            </div>

            <!-- hidden input -->
            <div id="hidden-inputs"></div>

            <!-- マイ食材から追加 -->
            @if($myIngredients->isNotEmpty())
                <div class="mt-4">
                    <p class="text-xs text-gray-400 mb-2">よく使う食材から追加：</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($myIngredients as $ingredient)
                            <button type="button"
                                onclick="addIngredientByName('{{ $ingredient->name }}')"
                                class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs hover:bg-gray-200">
                                + {{ $ingredient->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- フィルター -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="font-bold text-gray-700 mb-3">絞り込み（任意）</h2>

            <div class="grid grid-cols-2 gap-4">
                <!-- ジャンル -->
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">ジャンル</label>
                    <select name="genre" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">指定なし</option>
                        <option value="和食">和食</option>
                        <option value="洋食">洋食</option>
                        <option value="中華">中華</option>
                        <option value="イタリアン">イタリアン</option>
                        <option value="その他">その他</option>
                    </select>
                </div>

                <!-- 調理時間 -->
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">調理時間</label>
                    <select name="cooking_time" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">指定なし</option>
                        <option value="15">15分以内</option>
                        <option value="30">30分以内</option>
                        <option value="60">60分以内</option>
                    </select>
                </div>

                <!-- カロリー -->
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">カロリー</label>
                    <select name="calories" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">指定なし</option>
                        <option value="300">300kcal以内</option>
                        <option value="500">500kcal以内</option>
                        <option value="800">800kcal以内</option>
                    </select>
                </div>

                <!-- 難易度 -->
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">難易度</label>
                    <select name="difficulty" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">指定なし</option>
                        <option value="easy">かんたん</option>
                        <option value="medium">普通</option>
                        <option value="hard">むずかしい</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 生成ボタン -->
        <button type="submit"
            class="w-full bg-yellow-400 text-gray-800 py-3 rounded-xl font-bold text-lg hover:bg-yellow-300">
            ✨ AIでレシピ生成
        </button>

    </form>
</div>

<script>
let ingredients = [];

function addIngredient() {
    const input = document.getElementById('ingredient-input');
    const name = input.value.trim();
    if (!name) return;
    if (ingredients.includes(name)) {
        input.value = '';
        return;
    }
    ingredients.push(name);
    renderTags();
    input.value = '';
}

function addIngredientByName(name) {
    if (ingredients.includes(name)) return;
    ingredients.push(name);
    renderTags();
}

function removeIngredient(name) {
    ingredients = ingredients.filter(i => i !== name);
    renderTags();
}

function renderTags() {
    const tagsEl = document.getElementById('ingredient-tags');
    const hiddenEl = document.getElementById('hidden-inputs');

    tagsEl.innerHTML = ingredients.map(name => `
        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm flex items-center gap-1">
            ${name}
            <button type="button" onclick="removeIngredient('${name}')" class="text-blue-400 hover:text-blue-600">✕</button>
        </span>
    `).join('');

    hiddenEl.innerHTML = ingredients.map(name =>
        `<input type="hidden" name="ingredients[]" value="${name}">`
    ).join('');
}

// Enterキーで追加
document.getElementById('ingredient-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        addIngredient();
    }
});
</script>

@endsection
