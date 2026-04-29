<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン — KitchenAI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">

<div class="w-full max-w-md px-6">

    <!-- ロゴ -->
    <div class="text-center mb-8">
        <a href="{{ route('top') }}" class="text-2xl font-bold text-green-800">🍳 KitchenAI</a>
    </div>

    <!-- カード -->
    <div class="bg-white rounded-2xl shadow p-8">

        <!-- タイトル -->
        <div class="bg-red-700 text-white text-center py-3 rounded-xl mb-6">
            <h1 class="text-lg font-bold">🛡 管理者ログイン</h1>
        </div>

        <!-- アイコン -->
        <div class="text-center mb-6">
            <div class="text-5xl mb-2">🔐</div>
            <p class="text-gray-400 text-sm">管理者専用ページです</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm text-center">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.store') }}">
            @csrf

            <!-- メールアドレス -->
            <div class="mb-4">
                <input type="email" name="email" value="{{ old('email') }}"
                    placeholder="管理者メールアドレス"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-red-400 bg-gray-50"
                    required autofocus>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- パスワード -->
            <div class="mb-6">
                <input type="password" name="password"
                    placeholder="パスワード"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-red-400 bg-gray-50"
                    required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- ログインボタン -->
            <button type="submit"
                class="w-full bg-red-700 text-white py-3 rounded-xl font-bold text-sm hover:bg-red-600 mb-4">
                管理者ログイン
            </button>

        </form>

        <!-- 一般ログインへ -->
        <div class="text-center">
            <a href="{{ route('login') }}"
               class="text-sm text-gray-400 hover:underline">
                一般ログインはこちら
            </a>
        </div>

    </div>

</div>

</body>
</html>
