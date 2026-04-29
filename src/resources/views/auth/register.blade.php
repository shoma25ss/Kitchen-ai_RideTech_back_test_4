<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録 — KitchenAI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-green-50 min-h-screen flex items-center justify-center px-4 py-8">

<div class="w-full max-w-sm">

    <!-- ロゴ -->
    <div class="text-center mb-8">
        <div class="text-5xl mb-2">🍳</div>
        <a href="{{ route('top') }}" class="text-2xl font-bold text-green-800">KitchenAI</a>
    </div>

    <!-- カード -->
    <div class="bg-white rounded-2xl shadow-lg p-8">

        <h1 class="text-xl font-bold text-gray-700 text-center mb-6">新規登録</h1>

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <!-- 氏名 -->
            <div class="mb-4">
                <input type="text" name="name" value="{{ old('name') }}"
                    placeholder="氏名"
                    class="w-full border border-gray-200 rounded-xl px-4 py-4 text-sm focus:outline-none focus:border-green-500 bg-gray-50"
                    required autofocus>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- ニックネーム -->
            <div class="mb-4">
                <input type="text" name="nickname" value="{{ old('nickname') }}"
                    placeholder="ニックネーム（サイト上の表示名）"
                    class="w-full border border-gray-200 rounded-xl px-4 py-4 text-sm focus:outline-none focus:border-green-500 bg-gray-50">
            </div>

            <!-- メールアドレス -->
            <div class="mb-4">
                <input type="email" name="email" value="{{ old('email') }}"
                    placeholder="メールアドレス"
                    class="w-full border border-gray-200 rounded-xl px-4 py-4 text-sm focus:outline-none focus:border-green-500 bg-gray-50"
                    required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- パスワード -->
            <div class="mb-4">
                <input type="password" name="password"
                    placeholder="パスワード"
                    class="w-full border border-gray-200 rounded-xl px-4 py-4 text-sm focus:outline-none focus:border-green-500 bg-gray-50"
                    required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- パスワード確認 -->
            <div class="mb-6">
                <input type="password" name="password_confirmation"
                    placeholder="パスワード（確認）"
                    class="w-full border border-gray-200 rounded-xl px-4 py-4 text-sm focus:outline-none focus:border-green-500 bg-gray-50"
                    required>
            </div>

            <!-- 登録ボタン -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold text-base hover:bg-blue-500">
                確認画面へ →
            </button>

        </form>
    </div>

    <!-- ログインへ -->
    <div class="text-center mt-6">
        <span class="text-sm text-gray-500">すでにアカウントをお持ちの方は</span>
        <a href="{{ route('login') }}" class="text-sm text-green-600 font-bold hover:underline ml-1">
            ログイン
        </a>
    </div>

</div>

</body>
</html>
