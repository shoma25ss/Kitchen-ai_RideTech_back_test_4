@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-700 mb-6">管理ダッシュボード</h1>

    <!-- 統計カード -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <div class="text-4xl font-bold text-blue-600 mb-1">{{ $userCount }}</div>
            <div class="text-gray-400 text-sm">ユーザー数</div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <div class="text-4xl font-bold text-green-600 mb-1">{{ $recipeCount }}</div>
            <div class="text-gray-400 text-sm">レシピ数</div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <div class="text-4xl font-bold text-yellow-500 mb-1">{{ $historyCount }}</div>
            <div class="text-gray-400 text-sm">調理履歴数</div>
        </div>
    </div>

    <!-- メニュー -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('admin.users.index') }}"
           class="bg-white rounded-xl shadow p-6 flex items-center gap-4 hover:shadow-md transition">
            <div class="text-4xl">👤</div>
            <div>
                <div class="font-bold text-gray-700">ユーザー管理</div>
                <div class="text-gray-400 text-sm">登録ユーザーの確認・削除</div>
            </div>
        </a>
        <a href="{{ route('admin.recipes.index') }}"
           class="bg-white rounded-xl shadow p-6 flex items-center gap-4 hover:shadow-md transition">
            <div class="text-4xl">🍳</div>
            <div>
                <div class="font-bold text-gray-700">公開レシピ一覧</div>
                <div class="text-gray-400 text-sm">公開レシピの管理・削除</div>
            </div>
        </a>
    </div>

</div>

@endsection
