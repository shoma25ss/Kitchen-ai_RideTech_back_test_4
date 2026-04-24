@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-700 mb-2">✨ AIが提案するレシピ</h1>
    <p class="text-gray-400 text-sm mb-6">気に入ったレシピを選んで調理を始めましょう！</p>

    @if(empty($recipes))
        <div class="text-center text-gray-400 py-12">
            レシピを生成できませんでした。食材を変えて再度お試しください。
        </div>
        <a href="{{ route('ingredients.input') }}"
           class="block text-center bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-500 mt-4">
            ← 食材入力に戻る
        </a>
    @else
        <div class="space-y-6">
            @foreach($recipes as $index => $recipe)
                <div class="bg-white rounded-xl shadow p-6">

                    <!-- レシピ名 -->
                    <div class="flex items-start justify-between mb-3">
                        <h2 class="text-xl font-bold text-gray-800">{{ $recipe['title'] }}</h2>
                        <span class="text-2xl">🍳</span>
                    </div>

                    <!-- 説明 -->
                    <p class="text-gray-500 text-sm mb-4">{{ $recipe['description'] ?? '' }}</p>

                    <!-- タグ情報 -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if(!empty($recipe['genre']))
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                🍽 {{ $recipe['genre'] }}
                            </span>
                        @endif
                        @if(!empty($recipe['cooking_time']))
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                                ⏱ {{ $recipe['cooking_time'] }}分
                            </span>
                        @endif
                        @if(!empty($recipe['calories']))
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                🔥 {{ $recipe['calories'] }}kcal
                            </span>
                        @endif
                        @if(!empty($recipe['difficulty']))
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs">
                                ★ {{ ['easy'=>'かんたん','medium'=>'普通','hard'=>'むずかしい'][$recipe['difficulty']] ?? $recipe['difficulty'] }}
                            </span>
                        @endif
                    </div>

                    <!-- 食材リスト -->
                    @if(!empty($recipe['ingredients']))
                        <div class="mb-4">
                            <h3 class="text-sm font-bold text-gray-600 mb-2">材料</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($recipe['ingredients'] as $ingredient)
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">
                                        {{ $ingredient['name'] }} {{ $ingredient['quantity'] ?? '' }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- このレシピで調理するボタン -->
                    <form method="POST" action="{{ route('recipes.generate') }}">
                        @csrf
                        <input type="hidden" name="selected_index" value="{{ $index }}">
                        <input type="hidden" name="recipe_data" value="{{ json_encode($recipe) }}">
                        <button type="submit"
                            formaction="{{ url('/recipes/save') }}"
                            class="w-full bg-green-600 text-white py-3 rounded-xl font-bold hover:bg-green-500">
                            🍴 このレシピで調理する
                        </button>
                    </form>

                </div>
            @endforeach
        </div>

        <!-- 再生成 -->
        <div class="mt-6 text-center">
            <a href="{{ route('ingredients.input') }}"
               class="text-gray-400 hover:text-gray-600 text-sm underline">
                ← 食材入力に戻って再生成
            </a>
        </div>
    @endif

</div>

@endsection
