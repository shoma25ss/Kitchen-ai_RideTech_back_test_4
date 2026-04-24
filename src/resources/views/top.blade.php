@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- ヒーローセクション -->
    <div class="bg-green-700 text-white rounded-2xl p-8 mb-8 text-center">
        <h1 class="text-3xl font-bold mb-2">🍳 KitchenAI</h1>
        <p class="text-green-200 mb-4">食材を入力するだけでAIがレシピを自動生成！</p>
        @auth
            <a href="{{ route('ingredients.input') }}"
               class="bg-yellow-400 text-gray-800 px-6 py-2 rounded-full font-bold hover:bg-yellow-300 inline-block">
                🥕 食材を入力してレシピ生成
            </a>
        @else
            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}"
                   class="bg-white text-green-700 px-6 py-2 rounded-full font-bold hover:bg-gray-100">
                    ログイン
                </a>
                <a href="{{ route('register') }}"
                   class="bg-yellow-400 text-gray-800 px-6 py-2 rounded-full font-bold hover:bg-yellow-300">
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
            @foreach($recipes as $recipe)
                <div class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden">

                    <!-- 料理画像（仮） -->
                    <div class="h-40 bg-gradient-to-br from-yellow-100 to-orange-200 flex items-center justify-content-center text-5xl justify-center">
                        🍳
                    </div>

                    <!-- 料理情報 -->
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 mb-1 truncate">{{ $recipe->title }}</h3>
                        <p class="text-xs text-gray-400 mb-3">by {{ $recipe->user->name }}</p>

                        <!-- いいね・コメント -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <!-- いいねボタン -->
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

                                <!-- コメント数 -->
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

        <!-- ページネーション -->
        <div class="mt-8">
            {{ $recipes->links() }}
        </div>
    @endif

</div>

@endsection
