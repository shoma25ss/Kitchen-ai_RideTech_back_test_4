@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-700 mb-6">📋 料理履歴</h1>

    @if($histories->isEmpty())
        <div class="bg-white rounded-xl shadow p-12 text-center">
            <div class="text-5xl mb-4">🍳</div>
            <p class="text-gray-400 mb-4">まだ調理履歴がありません。</p>
            <a href="{{ route('ingredients.input') }}"
               class="bg-green-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-green-500 inline-block">
                レシピを生成する
            </a>
        </div>
    @else
        <div class="space-y-4">
        @foreach($histories as $history)
            @if(!$history->recipe)
                @continue
            @endif
           
            <div class="bg-white rounded-xl shadow p-4 mb-3">

              <!-- 上段：画像・タイトル・日付・星 -->
              <div class="flex gap-3 items-center mb-3">
                  <!-- 料理画像（仮） -->
                  <div class="w-14 h-14 bg-gradient-to-br from-yellow-100 to-orange-200 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">
                       🍳
                  </div>

                  <!-- 情報 -->
                  <div class="flex-1 min-w-0">
                  <h2 class="font-bold text-gray-800 text-sm truncate cursor-pointer"
                      onclick="this.classList.toggle('truncate')"
                      title="{{ $history->recipe->title }}">
                      {{ $history->recipe->title }}
                  </h2>
                      <p class="text-xs text-gray-400 mb-1">{{ $history->cooked_at->format('Y年m月d日') }}</p>
                      @if($history->rating)
                          <div class="flex gap-0.5">
                              @for($i = 1; $i <= 5; $i++)
                                  <span class="text-sm {{ $i <= $history->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                              @endfor
                          </div>
                      @endif
                  </div>
              </div>

        <!-- 下段：ボタン -->
        <div class="flex gap-2">
            <a href="{{ route('recipes.show', $history->recipe) }}"
               class="flex-1 bg-green-600 text-white py-2 rounded-lg text-xs font-bold hover:bg-green-500 text-center">
                詳細
            </a>
            <a href="{{ route('recipes.cook', $history->recipe) }}"
               class="flex-1 bg-yellow-400 text-gray-800 py-2 rounded-lg text-xs font-bold hover:bg-yellow-300 text-center">
                再調理
            </a>
        </div>

    </div>
@endforeach

        </div>

        <!-- ページネーション -->
        <div class="mt-6">
            {{ $histories->links() }}
        </div>
    @endif

</div>

@endsection
