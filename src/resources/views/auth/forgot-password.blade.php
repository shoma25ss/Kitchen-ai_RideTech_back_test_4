<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワードリセット — KitchenAI</title>
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

        <!-- アイコン -->
        <div class="text-center mb-6">
            <div class="text-4xl mb-2">📧</div>
            <h1 class="text-xl font-bold text-gray-700">パスワードリセット</h1>
            <p class="text-gray-400 text-sm mt-2">登録済みのメールアドレスを入力してください。リセット用のリンクをお送りします。</p>
        </div>

        <!-- 送信完了メッセージ -->
        @if(session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm text-center">
            パスワードリセット用のリンクをメールで送信しました。
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- メールアドレス -->
            <div class="mb-6">
                <input type="email" name="email" value="{{ old('email') }}"
                    placeholder="メールアドレス"
                    class="w-full border border-gray-200 rounded-xl px-4 py-4 text-sm focus:outline-none focus:border-green-500 bg-gray-50"
                    required autofocus>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 送信ボタン -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold text-base hover:bg-blue-500 mb-4 leading-tight">
                リセットメール<br>送信
            </button>

        </form>

        <!-- ログインへ戻る -->
        <div class="text-center">
            <a href="{{ route('login') }}"
               class="text-sm text-gray-400 hover:underline">
                ← ログイン画面へ戻る
            </a>
        </div>

    </div>

</div>

</body>
</html>
