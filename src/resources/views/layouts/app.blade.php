<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'KitchenAI') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <!-- ナビバー -->
    <nav class="bg-green-800 text-white px-6 py-3 flex items-center justify-between">
        <a href="{{ route('top') }}" class="text-xl font-bold">🍳 KitchenAI</a>

        <div class="flex items-center gap-4">
            @auth
                <a href="{{ route('ingredients.input') }}" class="bg-yellow-400 text-gray-800 px-4 py-1 rounded-full text-sm font-bold hover:bg-yellow-300">
                    🥕 レシピ生成
                </a>
                <a href="{{ route('histories.index') }}" class="text-sm hover:underline">履歴</a>
                <a href="{{ route('profile.edit') }}" class="text-sm hover:underline">マイページ</a>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-sm bg-red-600 px-3 py-1 rounded hover:bg-red-500">管理者</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm hover:underline">ログアウト</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm hover:underline">ログイン</a>
                <a href="{{ route('register') }}" class="bg-white text-green-800 px-4 py-1 rounded-full text-sm font-bold hover:bg-gray-100">
                    新規登録
                </a>
            @endauth
        </div>
    </nav>

    <!-- フラッシュメッセージ -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mx-6 mt-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mx-6 mt-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- メインコンテンツ -->
    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>

</body>
</html>
