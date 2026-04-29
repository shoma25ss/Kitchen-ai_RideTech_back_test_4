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
    <nav class="bg-green-800 text-white px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- ロゴ -->
            <a href="{{ route('top') }}" class="text-lg font-bold">🍳 KitchenAI</a>

            <!-- ハンバーガーボタン（スマホのみ表示） -->
            <button id="menu-btn" class="md:hidden flex flex-col gap-1.5 p-2">
                <span class="block w-6 h-0.5 bg-white"></span>
                <span class="block w-6 h-0.5 bg-white"></span>
                <span class="block w-6 h-0.5 bg-white"></span>
            </button>

            <!-- PC用メニュー -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                    <a href="{{ route('ingredients.input') }}"
                       class="bg-yellow-400 text-gray-800 px-4 py-1 rounded-full text-sm font-bold hover:bg-yellow-300">
                        🥕 レシピ生成
                    </a>
                    <a href="{{ route('histories.index') }}" class="text-sm hover:underline">履歴</a>
                    <a href="{{ route('profile.edit') }}" class="text-sm hover:underline">マイページ</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="text-sm bg-red-600 px-3 py-1 rounded hover:bg-red-500">管理者</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm hover:underline">ログアウト</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm hover:underline">ログイン</a>
                    <a href="{{ route('register') }}"
                       class="bg-white text-green-800 px-4 py-1 rounded-full text-sm font-bold hover:bg-gray-100">
                        新規登録
                    </a>
                @endauth
            </div>
        </div>

        <!-- スマホ用メニュー（ハンバーガー展開時） -->
        <div id="mobile-menu" class="hidden md:hidden mt-3 pb-2 border-t border-green-700 pt-3">
            @auth
                <a href="{{ route('ingredients.input') }}"
                   class="block bg-yellow-400 text-gray-800 px-4 py-3 rounded-xl text-sm font-bold mb-2 text-center">
                    🥕 レシピ生成
                </a>
                <a href="{{ route('histories.index') }}"
                   class="block text-sm py-3 border-b border-green-700 hover:bg-green-700 px-2 rounded">
                    📋 履歴
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="block text-sm py-3 border-b border-green-700 hover:bg-green-700 px-2 rounded">
                    👤 マイページ
                </a>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="block text-sm py-3 border-b border-green-700 hover:bg-green-700 px-2 rounded text-red-300">
                        🛡 管理者
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left text-sm py-3 hover:bg-green-700 px-2 rounded text-red-300">
                        🚪 ログアウト
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="block text-sm py-3 border-b border-green-700 hover:bg-green-700 px-2 rounded text-center">
                    ログイン
                </a>
                <a href="{{ route('register') }}"
                   class="block bg-white text-green-800 px-4 py-3 rounded-xl text-sm font-bold mt-2 text-center">
                    新規登録
                </a>
            @endauth
        </div>
    </nav>

    <!-- フラッシュメッセージ -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mx-4 mt-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mx-4 mt-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- メインコンテンツ -->
    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- ハンバーガーメニューのJS -->
    <script>
        document.getElementById('menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

</body>
</html>
