@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-700 mb-2">🍴 {{ $recipe->title }}</h1>
    <p class="text-gray-400 text-sm mb-6">手順に沿って調理しましょう！</p>

    <!-- プログレスバー -->
    <div class="bg-gray-200 rounded-full h-2 mb-6">
        <div id="progress-bar" class="bg-green-500 h-2 rounded-full transition-all duration-300"
             style="width: 0%"></div>
    </div>
    <p id="step-counter" class="text-center text-sm text-gray-400 mb-6">STEP 1 / {{ count($recipe->steps) }}</p>

    <!-- 手順カード -->
    <div id="steps-container">
        @foreach($recipe->steps as $index => $step)
            <div class="step-card bg-white rounded-xl shadow p-6 mb-4 {{ $index > 0 ? 'hidden' : '' }}"
                 data-step="{{ $index }}"
                 data-timer="{{ $step->timer_seconds ?? 0 }}">

                <!-- ステップ番号 -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold">
                        {{ $step->step_number }}
                    </div>
                    <h2 class="font-bold text-gray-700">ステップ {{ $step->step_number }}</h2>
                </div>

                <!-- 手順内容 -->
                <p class="text-gray-700 text-lg leading-relaxed mb-6">{{ $step->instruction }}</p>

                <!-- タイマー -->
                @if($step->timer_seconds)
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 text-center">
                        <div id="timer-display-{{ $index }}" class="text-4xl font-bold text-green-600 font-mono mb-2">
                            {{ gmdate('i:s', $step->timer_seconds) }}
                        </div>
                        <div class="flex flex-col gap-2">
                            <button onclick="startTimer({{ $index }}, {{ $step->timer_seconds }})"
                                class="w-full bg-green-600 text-white py-3 rounded-lg text-sm font-bold hover:bg-green-500">
                                スタート
                            </button>
                            <button onclick="resetTimer({{ $index }}, {{ $step->timer_seconds }})"
                               class="w-full bg-gray-400 text-white py-3 rounded-lg text-sm font-bold hover:bg-gray-300">
                               リセット
                            </button>
                        </div>
                    </div>
                @endif

            </div>
        @endforeach
    </div>

    <!-- ナビゲーションボタン -->
    <div class="flex gap-4 mt-6">
        <button id="prev-btn" onclick="prevStep()"
            class="flex-1 bg-gray-200 text-gray-700 py-4 rounded-xl font-bold text-lg hover:bg-gray-300 hidden">
            ◀ 戻る
        </button>
        <button id="next-btn" onclick="nextStep()"
            class="flex-1 bg-green-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-green-500">
            次へ ▶
        </button>
        <button id="finish-btn" onclick="finishCooking()"
            class="flex-1 bg-yellow-400 text-gray-800 py-4 rounded-xl font-bold text-lg hover:bg-yellow-300 hidden">
            🎉 調理完了！
        </button>
    </div>

    <!-- AIチャット -->
    <div class="bg-white rounded-xl shadow p-6 mt-8">
        <h2 class="font-bold text-gray-700 mb-3">💬 AIに質問する</h2>
        <div id="chat-messages" class="space-y-3 mb-4 max-h-60 overflow-y-auto"></div>
        <div class="flex flex-col gap-2">
            <input type="text" id="chat-input"
                placeholder="例：焦げてきたらどうすれば？"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-green-500">
            <button onclick="sendChat()"
                class="w-full bg-green-600 text-white py-3 rounded-lg text-sm font-bold hover:bg-green-500">
                送信
            </button>
        </div>
    </div>

    <!-- 調理完了フォーム -->
    <form id="finish-form" method="POST" action="{{ route('histories.store') }}" class="hidden">
        @csrf
        <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
        <input type="hidden" name="rating" id="rating-input" value="5">
    </form>

</div>

<script>
const totalSteps = {{ count($recipe->steps) }};
let currentStep = 0;
let timerIntervals = {};

function showStep(step) {
    document.querySelectorAll('.step-card').forEach(el => el.classList.add('hidden'));
    document.querySelector(`[data-step="${step}"]`).classList.remove('hidden');

    // プログレスバー更新
    const progress = ((step + 1) / totalSteps) * 100;
    document.getElementById('progress-bar').style.width = progress + '%';
    document.getElementById('step-counter').textContent = `STEP ${step + 1} / ${totalSteps}`;

    // ボタン表示切替
    document.getElementById('prev-btn').classList.toggle('hidden', step === 0);
    document.getElementById('next-btn').classList.toggle('hidden', step === totalSteps - 1);
    document.getElementById('finish-btn').classList.toggle('hidden', step !== totalSteps - 1);

}

function nextStep() {
    if (currentStep < totalSteps - 1) {
        currentStep++;
        showStep(currentStep);
    }
}

function prevStep() {
    if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
    }
}

function finishCooking() {
    window.location.href = '{{ route('cooking.complete', $recipe) }}';
}

// タイマー
function startTimer(index, seconds) {
    if (timerIntervals[index]) clearInterval(timerIntervals[index]);
    let remaining = seconds;

    timerIntervals[index] = setInterval(() => {
        remaining--;
        document.getElementById(`timer-display-${index}`).textContent =
            String(Math.floor(remaining / 60)).padStart(2, '0') + ':' +
            String(remaining % 60).padStart(2, '0');

        if (remaining <= 0) {
            clearInterval(timerIntervals[index]);
            alert('⏰ タイマーが終了しました！');
        }
    }, 1000);
}

function resetTimer(index, seconds) {
    if (timerIntervals[index]) clearInterval(timerIntervals[index]);
    document.getElementById(`timer-display-${index}`).textContent =
        String(Math.floor(seconds / 60)).padStart(2, '0') + ':' +
        String(seconds % 60).padStart(2, '0');
}

// AIチャット
async function sendChat() {
    const input = document.getElementById('chat-input');
    const question = input.value.trim();
    if (!question) return;

    // ユーザーメッセージ表示
    const chatMessages = document.getElementById('chat-messages');
    chatMessages.innerHTML += `
        <div class="flex justify-end">
            <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-xl text-sm max-w-xs">${question}</div>
        </div>`;
    input.value = '';

    try {
        const response = await fetch('{{ route('chat.ask') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                question: question,
                recipe_id: {{ $recipe->id }},
            }),
        });

        const data = await response.json();
        chatMessages.innerHTML += `
            <div class="flex justify-start">
                <div class="bg-gray-100 text-gray-800 px-4 py-2 rounded-xl text-sm max-w-xs">${data.answer}</div>
            </div>`;
        chatMessages.scrollTop = chatMessages.scrollHeight;
    } catch (e) {
        chatMessages.innerHTML += `
            <div class="text-red-400 text-xs text-center">エラーが発生しました。</div>`;
    }
}

// 初期表示時にボタンを設定
showStep(0);

// Enterキーで送信
document.getElementById('chat-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') sendChat();
});
</script>

@endsection
