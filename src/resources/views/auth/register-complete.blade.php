<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録完了 — KitchenAI</title>
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
    <div class="bg-white rounded-2xl shadow-lg p-8 text-center">

        <!-- 完了アイコン -->
        <div class="text-6xl mb-4">🎊</div>

        <h1 class="text-xl font-bold text-gray-700 mb-2">登録完了！</h1>
        <p class="text-gray-400 text-sm mb-8">ログインしてKitchenAIを始めましょう！</p>

        <!-- ログインボタン -->
        <a href="{{ route('login') }}"
           class="block w-full bg-blue-600 text-white py-4 rounded-xl font-bold text-base hover:bg-blue-500">
            ログイン画面へ
        </a>

    </div>

</div>

</body>
</html>
