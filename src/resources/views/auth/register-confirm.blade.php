<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録確認 — KitchenAI</title>
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

        <h1 class="text-xl font-bold text-gray-700 text-center mb-6">登録確認</h1>

        <!-- 確認内容 -->
        <div class="mb-6 space-y-3">
            <div class="bg-gray-50 rounded-xl px-4 py-3">
                <span class="text-gray-400 text-xs block mb-1">氏名</span>
                <span class="text-gray-700 font-bold text-sm">{{ $data['name'] }}</span>
            </div>
            <div class="bg-gray-50 rounded-xl px-4 py-3">
                <span class="text-gray-400 text-xs block mb-1">ニックネーム</span>
                <span class="text-gray-700 font-bold text-sm">{{ $data['nickname'] ?? '未設定' }}</span>
            </div>
            <div class="bg-gray-50 rounded-xl px-4 py-3">
                <span class="text-gray-400 text-xs block mb-1">メール</span>
                <span class="text-gray-700 font-bold text-sm break-all">{{ $data['email'] }}</span>
            </div>
            <div class="bg-gray-50 rounded-xl px-4 py-3">
                <span class="text-gray-400 text-xs block mb-1">パスワード</span>
                <span class="text-gray-700 font-bold text-sm">••••••••</span>
            </div>
        </div>


        <!-- ボタン -->
        <div class="flex gap-3">
            <a href="{{ route('register') }}"
               class="flex-1 bg-gray-200 text-gray-700 py-4 rounded-xl font-bold text-sm text-center hover:bg-gray-300">
                ← 修正
            </a>
            <form method="POST" action="{{ route('register') }}" class="flex-1">
                @csrf
                <input type="hidden" name="name"     value="{{ $data['name'] }}">
                <input type="hidden" name="nickname" value="{{ $data['nickname'] ?? '' }}">
                <input type="hidden" name="email"    value="{{ $data['email'] }}">
                <input type="hidden" name="password" value="{{ $data['password'] }}">
                <input type="hidden" name="password_confirmation" value="{{ $data['password'] }}">
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold text-sm hover:bg-blue-500">
                    登録する
                </button>
            </form>
        </div>

    </div>

</div>

</body>
</html>
