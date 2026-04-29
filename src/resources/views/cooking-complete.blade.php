@extends('layouts.app')

@section('content')

<div class="max-w-md mx-auto">

    <div class="bg-white rounded-2xl shadow p-8 text-center">

        <!-- 完了アイコン -->
        <div class="text-6xl mb-4">🎉</div>

        <!-- レシピ名 -->
        <p class="text-gray-700 font-bold text-lg mb-6">{{ $recipe->title }}</p>

        <!-- 評価 -->
        <div class="mb-6">
            <p class="text-gray-400 text-sm mb-3">今回の調理はいかがでしたか？</p>
            <div class="flex justify-center gap-1 w-full" id="star-rating">
               @for($i = 1; $i <= 5; $i++)
                   <button type="button" onclick="setRating({{ $i }})"
                       class="star text-3xl transition-transform hover:scale-110 flex-1 max-w-12"
                       data-value="{{ $i }}">
                       ☆
                    </button>
                @endfor
            </div>
        </div>

        <!-- ボタン -->
        <form method="POST" action="{{ route('histories.store') }}" id="complete-form">
            @csrf
            <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
            <input type="hidden" name="rating" id="rating-value" value="">

            <!-- 公開する -->
            <div class="mb-3">
                <button type="button"
                    onclick="document.getElementById('publish-form').submit()"
                    class="w-full bg-gray-200 text-gray-700 py-3 rounded-xl font-bold text-sm hover:bg-gray-300">
                    公開する
                </button>
            </div>

            <!-- 保存 -->
            <div class="mb-3">
                <button type="submit" form="complete-form"
                    class="w-full bg-green-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-green-500">
                    保存
                </button>
            </div>

            <!-- 履歴へ -->
            <a href="{{ route('histories.index') }}"
               class="block w-full bg-gray-50 text-gray-500 py-3 rounded-xl text-sm text-center hover:bg-gray-100">
                📋 履歴へ
            </a>

        </form>
        <!-- 公開用フォーム（非表示） -->
        <form id="publish-form" method="POST" action="{{ route('recipes.publish', $recipe) }}">
            @csrf
        </form>
    </div>
</div>

<script>
let selectedRating = 0;

function setRating(value) {
    selectedRating = value;
    document.getElementById('rating-value').value = value;

    document.querySelectorAll('.star').forEach((star, index) => {
        star.textContent = index < value ? '★' : '☆';
        star.style.color = index < value ? '#F59E0B' : '#D1D5DB';
    });
}
</script>

@endsection
