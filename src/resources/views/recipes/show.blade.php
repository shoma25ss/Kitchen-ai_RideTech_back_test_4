@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <!-- レシピヘッダー -->
    <div class="bg-white rounded-xl shadow p-6 mb-4">

        <!-- 料理画像（仮） -->
        <div class="h-48 bg-gradient-to-br from-yellow-100 to-orange-200 rounded-xl flex items-center justify-center text-6xl mb-4">
            🍳
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $recipe->title }}</h1>
        <p class="text-gray-400 text-sm mb-3">by {{ $recipe->user->display_name }}</p>

        @if($recipe->description)
            <p class="text-gray-600 text-sm mb-4">{{ $recipe->description }}</p>
        @endif

        <!-- タグ情報 -->
        <div class="flex flex-wrap gap-2 mb-4">
            @if($recipe->genre)
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                    🍽 {{ $recipe->genre }}
                </span>
            @endif
            @if($recipe->cooking_time)
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                    ⏱ {{ $recipe->cooking_time }}分
                </span>
            @endif
            @if($recipe->calories)
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                    🔥 {{ $recipe->calories }}kcal
                </span>
            @endif
            @if($recipe->difficulty)
                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs">
                    ★ {{ ['easy'=>'かんたん','medium'=>'普通','hard'=>'むずかしい'][$recipe->difficulty] ?? $recipe->difficulty }}
                </span>
            @endif
        </div>

        <!-- いいね・公開ボタン -->
        <div class="flex gap-3">
            @auth
                <form method="POST" action="{{ route('recipes.like', $recipe) }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 px-4 py-2 rounded-xl border text-sm font-bold
                        {{ $isLiked ? 'bg-red-50 border-red-300 text-red-500' : 'bg-gray-50 border-gray-300 text-gray-500' }}">
                        ❤️ {{ $recipe->likes->count() }}
                        {{ $isLiked ? 'いいね済み' : 'いいね' }}
                    </button>
                </form>

                @if($recipe->user_id === auth()->id())
                    <form method="POST" action="{{ route('recipes.publish', $recipe) }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 rounded-xl border text-sm font-bold
                            {{ $recipe->is_public ? 'bg-gray-50 border-gray-300 text-gray-500' : 'bg-green-50 border-green-300 text-green-600' }}">
                            {{ $recipe->is_public ? '非公開にする' : '公開する' }}
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </div>

    <!-- 材料 -->
    <div class="bg-white rounded-xl shadow p-6 mb-4">
        <h2 class="font-bold text-gray-700 mb-3">🥕 材料</h2>
        <div class="space-y-2">
            @foreach($recipe->ingredients as $ingredient)
                <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                    <span class="text-gray-700">{{ $ingredient->name }}</span>
                    <span class="text-gray-400 text-sm">{{ $ingredient->quantity }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 調理スタートボタン -->
    @auth
        <a href="{{ route('recipes.cook', $recipe) }}"
            class="block w-full bg-green-600 text-white py-4 rounded-xl font-bold text-lg text-center hover:bg-green-500 mb-4">
            🍴 調理スタート
        </a>
    @endauth

    <!-- コメント -->
    <div class="bg-white rounded-xl shadow p-6 mb-4">
        <h2 class="font-bold text-gray-700 mb-4">💬 コメント（{{ $recipe->comments->count() }}）</h2>

        <!-- コメント一覧 -->
        @forelse($recipe->comments as $comment)
            <div class="flex gap-3 mb-4 pb-4 border-b border-gray-100 last:border-0">
                <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">
                    {{ mb_substr($comment->user->display_name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-bold text-gray-700">{{ $comment->user->name }}</span>
                        <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-600 text-sm">{{ $comment->body }}</p>
                    @if(auth()->check() && $comment->user_id === auth()->id())
                        <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="mt-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-600">削除</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-400 text-sm text-center py-4">まだコメントがありません。</p>
        @endforelse

        <!-- コメント投稿 -->
        @auth
            <form method="POST" action="{{ route('comments.store', $recipe) }}" class="mt-4">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="body"
                        placeholder="コメントを入力..."
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-green-500">
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-500">
                        投稿
                    </button>
                </div>
            </form>
        @endauth
    </div>

</div>

@endsection
