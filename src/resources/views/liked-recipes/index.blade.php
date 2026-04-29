@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-700 mb-6">❤️ いいねした料理</h1>

    @if($recipes->isEmpty())
        <div class="bg-white rounded-xl shadow p-12 text-center">
            <div class="text-5xl mb-4">❤️</div>
            <p class="text-gray-400 mb-4">まだいいねした料理がありません。</p>
            <a href="{{ route('top') }}"
               class="bg-green-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-green-500 inline-block">
                トップページへ
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($recipes as $like)
                <div class="bg-white rounded-xl shadow p-4 flex gap-4 items-center">

                    <!-- 料理画像（仮） -->
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-100 to-orange-200 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">
                        🍳
                    </div>

                    <!-- 情報 -->
                    <div class="flex-1">
                        <h2 class="font-bold text-gray-800 mb-1">{{ $like->recipe->title }}</h2>
                        <p class="text-xs text-gray-400 mb-2">by {{ $like->recipe->user->name }}</p>

                        <!-- タグ -->
                        <div class="flex flex-wrap gap-1">
                            @if($like->recipe->genre)
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs">
                                    {{ $like->recipe->genre }}
                                </span>
                            @endif
                            @if($like->recipe->cooking_time)
                                <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs">
                                    ⏱ {{ $like->recipe->cooking_time }}分
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- ボタン -->
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('recipes.show', $like->recipe) }}"
                           class="bg-green-600 text-white px-3 py-2 rounded-lg text-xs font-bold hover:bg-green-500 text-center">
                            詳細
                        </a>
                        <form method="POST" action="{{ route('recipes.like', $like->recipe) }}">
                            @csrf
                            <button type="submit"
                                class="bg-red-100 text-red-500 px-3 py-2 rounded-lg text-xs font-bold hover:bg-red-200 w-full">
                                ❤️ 解除
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- ページネーション -->
        <div class="mt-6">
            {{ $recipes->links() }}
        </div>
    @endif

</div>

@endsection
