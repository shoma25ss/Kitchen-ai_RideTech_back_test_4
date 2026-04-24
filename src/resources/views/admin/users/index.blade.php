@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-700">ユーザー管理</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-400 hover:underline">
            ← ダッシュボードへ
        </a>
    </div>

    <!-- 検索 -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
        <div class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="名前・メールで検索..."
                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-green-500">
            <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-500">
                検索
            </button>
        </div>
    </form>

    <!-- ユーザー一覧 -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 text-gray-600">名前</th>
                    <th class="text-left px-4 py-3 text-gray-600">メール</th>
                    <th class="text-left px-4 py-3 text-gray-600">ロール</th>
                    <th class="text-left px-4 py-3 text-gray-600">登録日</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-bold text-gray-700">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600' }}">
                                {{ $user->role === 'admin' ? '管理者' : '一般' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-400 text-xs">
                            {{ $user->created_at->format('Y/m/d') }}
                        </td>
                        <td class="px-4 py-3">
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('本当に削除しますか？')"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-red-400">
                                        削除
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ページネーション -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>

</div>

@endsection
