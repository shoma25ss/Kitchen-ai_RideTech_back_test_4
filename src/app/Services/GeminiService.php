<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
  private string $apiKey;
  private string $model;
  private string $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';

  public function __construct()
  {
      $this->apiKey = config('services.groq.api_key');
      $this->model  = config('services.groq.model', 'llama-3.1-8b-instant');
  }

  public function generateRecipes(array $ingredients, array $filters = []): array
  {
      $ingredientList = implode('、', $ingredients);
      $filterText = '';

      if (!empty($filters['genre']))        $filterText .= "ジャンル：{$filters['genre']}、";
      if (!empty($filters['cooking_time'])) $filterText .= "調理時間：{$filters['cooking_time']}分以内、";
      if (!empty($filters['calories']))     $filterText .= "カロリー：{$filters['calories']}kcal以内、";
      if (!empty($filters['difficulty']))   $filterText .= "難易度：{$filters['difficulty']}、";

      $prompt = <<<PROMPT
以下の食材とフィルター条件を元に、レシピを3品提案してください。
必ず以下のJSON形式のみで返してください。それ以外のテキストは不要です。

食材：{$ingredientList}
{$filterText}

[
{
  "title": "料理名",
  "description": "料理の簡単な説明",
  "genre": "和食",
  "cooking_time": 30,
  "calories": 450,
  "difficulty": "easy",
  "ingredients": [
    {"name": "食材名", "quantity": "100g"}
  ],
  "steps": [
    {"step_number": 1, "instruction": "手順の説明", "timer_seconds": null}
  ]
}
]
PROMPT;

      $response = Http::withToken($this->apiKey)
          ->post($this->baseUrl, [
              'model'    => $this->model,
              'messages' => [
                  ['role' => 'user', 'content' => $prompt]
              ],
              'temperature' => 0.7,
          ]);

      $text = $response->json('choices.0.message.content', '');

      // コードブロックを除去
      $text = preg_replace('/```json\s*/i', '', $text);
      $text = preg_replace('/```\s*/i', '', $text);
      $text = trim($text);

      // [ から始まる位置を探す
      $start = strpos($text, '[');
      if ($start === false) return [];

      $jsonText = substr($text, $start);

      // 閉じ括弧が足りない場合補完
      $open  = substr_count($jsonText, '[');
      $close = substr_count($jsonText, ']');
      if ($open > $close) {
      $jsonText .= str_repeat(']', $open - $close);
      }

      $decoded = json_decode($jsonText, true);
      if (is_array($decoded) && !empty($decoded)) {
      return $decoded;
      }
  }

  public function chat(string $question, string $recipeContext = ''): string
  {
      $context = $recipeContext
          ? "現在調理中のレシピ：{$recipeContext}\n\n"
          : '';

      $prompt = $context . "質問：{$question}";

      $response = Http::withToken($this->apiKey)
          ->post($this->baseUrl, [
              'model'    => $this->model,
              'messages' => [
                  ['role' => 'user', 'content' => $prompt]
              ],
              'temperature' => 0.7,
          ]);

      return $response->json('choices.0.message.content', 'エラーが発生しました。');
  }
}
