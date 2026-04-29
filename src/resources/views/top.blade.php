@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- ヒーローセクション -->
    <div class="bg-green-700 text-white rounded-2xl p-6 mb-8 text-center">
        <div class="text-4xl mb-3">🍳</div>
        <h1 class="text-2xl font-bold mb-2">KitchenAI</h1>
        <p class="text-green-200 text-sm mb-6">食材を入力するだけで<br>AIがレシピを自動生成！</p>
        @auth
            <a href="{{ route('ingredients.input') }}"
               class="inline-block bg-yellow-400 text-gray-800 px-8 py-3 rounded-full font-bold hover:bg-yellow-300">
                🥕 食材を入力してレシピ生成
            </a>
        @else
           <div class="flex flex-col items-center gap-3">
                <a href="{{ route('login') }}"
                   class="w-48 bg-white text-green-700 px-6 py-3 rounded-full font-bold hover:bg-gray-100 text-center">
                    ログイン
                </a>
                <a href="{{ route('register') }}"
                   class="w-48 bg-yellow-400 text-gray-800 px-6 py-3 rounded-full font-bold hover:bg-yellow-300 text-center">
                    新規登録
                </a>
            </div>
        @endauth
    </div>


    <!-- みんなの料理 -->
<h2 class="text-xl font-bold text-gray-700 mb-4">みんなの料理</h2>

@if($recipes->isEmpty())
    <div class="text-center text-gray-400 py-12">
        まだ公開されているレシピがありません。
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($recipes as $index => $recipe)
            <div class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden relative
                {{ !auth()->check() && $index >= 3 ? 'opacity-0 pointer-events-none' : '' }}">

                <!-- 料理画像（仮） -->
                <div class="h-40 bg-gradient-to-br from-yellow-100 to-orange-200 flex items-center justify-center text-5xl">
                    🍳
                </div>

                <!-- 料理情報 -->
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 mb-1 truncate">{{ $recipe->title }}</h3>
                    <p class="text-xs text-gray-400 mb-3">by {{ $recipe->user->display_name }}</p>

                    <!-- いいね・コメント -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            @auth
                                <form method="POST" action="{{ route('recipes.like', $recipe) }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-1 text-sm text-red-500 hover:text-red-400">
                                        ❤️ {{ $recipe->likes->count() }}
                                    </button>
                                </form>
                            @else
                                <span class="text-sm text-gray-400">❤️ {{ $recipe->likes->count() }}</span>
                            @endauth
                            <span class="text-sm text-gray-400">💬 {{ $recipe->comments->count() }}</span>
                        </div>
                        <a href="{{ route('recipes.show', $recipe) }}"
                           class="text-xs bg-green-600 text-white px-3 py-1 rounded-full hover:bg-green-500">
                            詳細
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- ログイン前のぼかし・誘導 -->
    @guest
        <div class="relative mt-[-200px]">
            <div class="h-48 bg-gradient-to-t from-white via-white to-transparent"></div>
            <div class="bg-white text-center py-6 px-4 rounded-2xl shadow-lg mx-4">
                <div class="text-3xl mb-2">🍳</div>
                <p class="font-bold text-gray-700 mb-1">もっと見るにはログインが必要です</p>
                <p class="text-gray-400 text-sm mb-4">無料で登録してすべてのレシピを見よう！</p>
                <div class="flex flex-col gap-3 items-center">
                    <a href="{{ route('login') }}"
                       class="w-36 bg-green-600 text-white py-2 rounded-full font-bold text-sm text-center hover:bg-green-500">
                        ログイン
                    </a>
                    <a href="{{ route('register') }}"
                       class="w-36 bg-yellow-400 text-gray-800 py-2 rounded-full font-bold text-sm text-center hover:bg-yellow-300">
                        新規登録
                    </a>
                </div>
            </div>
        </div>
    @endguest

    <!-- ログイン後のページネーション -->
    @auth
        <div class="mt-8">
            {{ $recipes->links() }}
        </div>
    @endauth
@endif

</div>

@endsection
