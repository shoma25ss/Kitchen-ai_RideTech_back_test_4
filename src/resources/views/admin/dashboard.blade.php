@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-700 mb-6 whitespace-nowrap">管理ダッシュボード</h1>

    <!-- 統計カード -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <div class="text-4xl font-bold text-red-500 mb-1">{{ $userCount }}</div>
            <div class="text-gray-400 text-sm">ユーザー数</div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <div class="text-4xl font-bold text-red-500 mb-1">{{ $recipeCount }}</div>
            <div class="text-gray-400 text-sm">生成数</div>
        </div>
    </div>

    <!-- グラフ -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="font-bold text-gray-700 mb-4">月別レシピ生成数</h2>
        <div class="flex items-end gap-2 h-32">
            @forelse($monthlyData as $data)
                <div class="flex-1 flex flex-col items-center gap-1">
                    <div class="w-full bg-red-300 rounded-t"
                         style="height: {{ max(20, ($data->count / max($monthlyData->max('count'), 1)) * 100) }}px">
                    </div>
                    <span class="text-xs text-gray-400">{{ $data->month }}月</span>
                </div>
            @empty
                <div class="w-full text-center text-gray-400 text-sm">データがありません</div>
            @endforelse
        </div>
    </div>

    <!-- メニュー -->
    <div class="bg-white rounded-xl shadow p-4 mb-4">
        <div class="grid grid-cols-2 gap-3 mb-3">
            <a href="{{ route('admin.users.index') }}"
               class="bg-red-700 text-white py-3 rounded-xl font-bold text-sm text-center hover:bg-red-600 flex items-center justify-center leading-tight">
                ユーザー<br>管理
            </a>
            <a href="{{ route('admin.recipes.index') }}"
               class="bg-red-700 text-white py-3 rounded-xl font-bold text-sm text-center hover:bg-red-600 flex items-center justify-center">
                レシピ審査
            </a>
        </div>
        <a href="{{ route('admin.recipes.published') }}"
            class="block w-full bg-red-700 text-white py-3 rounded-xl font-bold text-sm text-center hover:bg-red-600">
             公開レシピ一覧
        </a>
    </div>
</div>

@endsection
