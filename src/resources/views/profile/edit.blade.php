@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-700 mb-6">👤 マイページ</h1>

    <!-- プロフィール -->
    <div class="bg-white rounded-xl shadow p-6 mb-4">
        <div class="flex flex-col items-center text-center">
            <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center text-4xl mb-3">
               👤
            </div>
            <div class="font-bold text-gray-800 text-lg mb-1">{{ auth()->user()->display_name }}</div>
            <div class="text-gray-400 text-xs w-full cursor-pointer truncate"
                 onclick="this.classList.toggle('truncate')"
                 title="{{ auth()->user()->email }}">
                {{ auth()->user()->email }}
            </div>
        </div>
    </div>

    <!-- ニックネーム変更フォーム -->
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label class="text-xs text-gray-500 mb-1 block">ニックネーム変更</label>
            <input type="text" name="nickname"
                value="{{ auth()->user()->nickname }}"
                placeholder="ニックネームを入力"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-green-500">
        </div>
        <!-- nameは必須なので隠しフィールドで送る -->
        <input type="hidden" name="name" value="{{ auth()->user()->name }}">
        <input type="hidden" name="email" value="{{ auth()->user()->email }}">
        <button type="submit"
            class="w-full bg-green-600 text-white py-2 rounded-lg text-sm font-bold hover:bg-green-500">
            ニックネームを更新する
        </button>
    </form>

    <!-- メニュー -->
    <div class="bg-white rounded-xl shadow p-4 mb-4">
        <div class="space-y-2">
            <a href="{{ route('histories.index') }}"
               class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                <span class="text-sm font-bold text-gray-700">📋 料理履歴</span>
                <span class="text-gray-400">›</span>
            </a>
            <a href="{{ route('liked-recipes.index') }}"
               class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                <span class="text-sm font-bold text-gray-700">❤️ いいねした料理</span>
                <span class="text-gray-400">›</span>
            </a>
            <a href="{{ route('my-ingredients.index') }}"
               class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                <span class="text-sm font-bold text-gray-700">🥕 マイ食材管理</span>
                <span class="text-gray-400">›</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-between p-4 bg-red-50 rounded-lg hover:bg-red-100">
                    <span class="text-sm font-bold text-red-500">ログアウト</span>
                    <span class="text-red-300">›</span>
                </button>
            </form>
        </div>
    </div>

</div>

@endsection
