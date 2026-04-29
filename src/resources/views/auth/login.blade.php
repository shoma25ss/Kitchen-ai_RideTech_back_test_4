<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン — KitchenAI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-green-50 min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-sm">

    <!-- ロゴ -->
    <div class="text-center mb-8">
        <div class="text-5xl mb-2">🍳</div>
        <a href="{{ route('top') }}" class="text-2xl font-bold text-green-800">KitchenAI</a>
    </div>

    <!-- カード -->
    <div class="bg-white rounded-2xl shadow-lg p-8">

        <h1 class="text-xl font-bold text-gray-700 text-center mb-6">ログイン</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- メールアドレス -->
            <div class="mb-4">
                <input type="email" name="email" value="{{ old('email') }}"
                    placeholder="メールアドレス"
                    class="w-full border border-gray-200 rounded-xl px-4 py-4 text-sm focus:outline-none focus:border-green-500 bg-gray-50"
                    required autofocus>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- パスワード -->
            <div class="mb-6">
                <input type="password" name="password"
                    placeholder="パスワード"
                    class="w-full border border-gray-200 rounded-xl px-4 py-4 text-sm focus:outline-none focus:border-green-500 bg-gray-50"
                    required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- ログインボタン -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold text-base hover:bg-blue-500 mb-4">
                ログイン
            </button>

            <!-- パスワード忘れ -->
            @if(Route::has('password.request'))
                <div class="text-center">
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-blue-400 hover:underline">
                        パスワードを忘れた方
                    </a>
                </div>
            @endif

        </form>
    </div>

    <!-- 新規登録へ -->
    <div class="text-center mt-6">
        <span class="text-sm text-gray-500">アカウントをお持ちでない方は</span>
        <a href="{{ route('register') }}" class="text-sm text-green-600 font-bold hover:underline ml-1">
            新規登録
        </a>
    </div>

</div>

</body>
</html>
