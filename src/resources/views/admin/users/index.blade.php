@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <!-- タイトル -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-700">👤 ユーザー管理</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-400 hover:underline">
            ← ダッシュボードへ
        </a>
    </div>

    <!-- 検索 -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
        <div class="flex flex-col gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="名前・メールで検索..."
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-green-500">
            <button type="submit"
            class="w-full bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-500">
            検索
            </button>
        </div>
    </form>


    <!-- ユーザー一覧 -->
    <div class="space-y-3">
        @foreach($users as $user)
            <div class="bg-white rounded-xl shadow p-4">
                <div class="flex items-center justify-between gap-3">

                    <!-- ユーザー情報 -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-gray-700 text-sm">{{ $user->display_name }}</span>
                            <span class="px-2 py-0.5 rounded-full text-xs
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600' }}">
                                {{ $user->role === 'admin' ? '管理者' : '一般' }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-400 truncate cursor-pointer"
                             onclick="this.classList.toggle('truncate')"
                             title="{{ $user->email }}">
                            {{ $user->email }}
                        </div>
                        <div class="text-xs text-gray-300 mt-1">
                            {{ $user->created_at->format('Y/m/d') }}
                        </div>
                    </div>

                    <!-- 削除ボタン -->
                    @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('本当に削除しますか？')"
                                class="bg-red-500 text-white px-3 py-2 rounded-lg text-xs font-bold hover:bg-red-400">
                                削除
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        @endforeach
    </div>

    <!-- ページネーション -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>

</div>

@endsection
