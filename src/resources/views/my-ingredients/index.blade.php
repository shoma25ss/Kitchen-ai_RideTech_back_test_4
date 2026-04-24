@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-700 mb-6">🥕 マイ食材管理</h1>

    <!-- 食材追加フォーム -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="font-bold text-gray-700 mb-3">食材を追加</h2>
        <form method="POST" action="{{ route('my-ingredients.store') }}">
            @csrf
            <div class="flex gap-2">
                <input type="text" name="name"
                    placeholder="例：たまご、豚肉、玉ねぎ"
                    class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-green-500">
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-500">
                    追加
                </button>
            </div>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </form>
    </div>

    <!-- 食材一覧 -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="font-bold text-gray-700 mb-3">登録済み食材</h2>

        @if($myIngredients->isEmpty())
            <p class="text-gray-400 text-sm text-center py-4">
                まだ食材が登録されていません。
            </p>
        @else
            <div class="flex flex-wrap gap-2">
                @foreach($myIngredients as $ingredient)
                    <div class="flex items-center gap-1 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full">
                        <span class="text-blue-700 text-sm">{{ $ingredient->name }}</span>
                        <form method="POST" action="{{ route('my-ingredients.destroy', $ingredient) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-300 hover:text-red-400 ml-1 text-xs">
                                ✕
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- 食材入力画面に展開 -->
    @if($myIngredients->isNotEmpty())
        <a href="{{ route('ingredients.input') }}"
           class="block w-full bg-yellow-400 text-gray-800 py-4 rounded-xl font-bold text-center hover:bg-yellow-300">
            🥕 この食材でレシピ生成する
        </a>
    @endif

</div>

@endsection
