@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-700">公開レシピ一覧</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-400 hover:underline">
            ← ダッシュボードへ
        </a>
    </div>

    <!-- 検索 -->
    <form method="GET" action="{{ route('admin.recipes.index') }}" class="mb-6">
        <div class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="レシピ名で検索..."
                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-green-500">
            <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-500">
                検索
            </button>
        </div>
    </form>

    <!-- レシピ一覧 -->
    <div class="space-y-3">
        @forelse($recipes as $recipe)
            <div class="bg-white rounded-xl shadow p-4 flex items-center gap-4">

                <div class="w-12 h-12 bg-gradient-to-br from-yellow-100 to-orange-200 rounded-xl flex items-center justify-center text-xl flex-shrink-0">
                    🍳
                </div>

                <div class="flex-1">
                    <h2 class="font-bold text-gray-800 text-sm">{{ $recipe->title }}</h2>
                    <div class="flex gap-3 mt-1">
                        <span class="text-xs text-gray-400">by {{ $recipe->user->name }}</span>
                        <span class="text-xs text-red-400">❤️ {{ $recipe->likes->count() }}</span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <form method="POST" action="{{ route('admin.recipes.toggle', $recipe) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="bg-gray-100 text-gray-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-gray-200">
                            非公開
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.recipes.destroy', $recipe) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('本当に削除しますか？')"
                            class="bg-red-500 text-white px-3 py-2 rounded-lg text-xs font-bold hover:bg-red-400">
                            削除
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="text-center text-gray-400 py-12">
                公開中のレシピがありません。
            </div>
        @endforelse
    </div>

    <!-- ページネーション -->
    <div class="mt-6">
        {{ $recipes->links() }}
    </div>

</div>

@endsection
