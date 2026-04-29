@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <!-- タイトル -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-700">🍳 公開レシピ一覧</h1>
        <p class="text-sm text-gray-400">承認済みの公開レシピを管理します</p>
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-400 hover:underline">
            ← ダッシュボードへ
        </a>
    </div>

    <!-- 検索 -->
    <form method="GET" action="{{ route('admin.recipes.published') }}" class="mb-6">
        <div class="flex flex-col gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="レシピを検索..."
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-red-400">
            <button type="submit"
                class="w-full bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-600">
                検索
            </button>
        </div>
    </form>

    <!-- レシピ一覧 -->
    <div class="space-y-3">
        @forelse($recipes as $recipe)
            <div class="bg-white rounded-xl shadow p-4">

                <!-- レシピ情報 -->
                <div class="mb-3">
                    <h2 class="font-bold text-gray-800 text-sm truncate cursor-pointer mb-1"
                        onclick="this.classList.toggle('truncate')">
                        {{ $recipe->title }}
                    </h2>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-red-400">❤️ {{ $recipe->likes->count() }}</span>
                        <span class="text-xs text-gray-400">👤 {{ $recipe->user->display_name }}</span>
                    </div>
                </div>

                <!-- ボタン -->
                <div class="flex gap-2">
                    <form method="POST" action="{{ route('admin.recipes.unpublish', $recipe) }}" class="flex-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="w-full bg-gray-400 text-white py-2 rounded-lg text-xs font-bold hover:bg-gray-300">
                            非公開
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.recipes.destroy', $recipe) }}" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('本当に削除しますか？')"
                            class="w-full bg-red-500 text-white py-2 rounded-lg text-xs font-bold hover:bg-red-400">
                            削除
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="bg-white rounded-xl shadow p-12 text-center">
                <div class="text-4xl mb-3">🍳</div>
                <p class="text-gray-400 text-sm">公開中のレシピがありません</p>
            </div>
        @endforelse
    </div>

    <!-- ページネーション -->
    <div class="mt-6">
        {{ $recipes->links() }}
    </div>

</div>

@endsection
