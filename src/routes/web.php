<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\CookingHistoryController;
use App\Http\Controllers\MyIngredientController;
use App\Http\Controllers\RecipeLikeController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RecipeController as AdminRecipeController;

// トップページ（未ログインでも閲覧可）
Route::get('/', [RecipeController::class, 'index'])->name('top');

// 認証が必要なルート
Route::middleware('auth')->group(function () {

    // ダッシュボード
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // プロフィール
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 食材入力・レシピ生成
    Route::get('/ingredients/input', [IngredientController::class, 'index'])->name('ingredients.input');
    Route::post('/recipes/generate', [RecipeController::class, 'generate'])->name('recipes.generate');
    Route::post('/recipes/save', [RecipeController::class, 'save'])->name('recipes.save');

    // レシピ
    Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
    Route::post('/recipes/{recipe}/publish', [RecipeController::class, 'publish'])->name('recipes.publish');

    // 調理ナビ
    Route::get('/recipes/{recipe}/cook', [RecipeController::class, 'cook'])->name('recipes.cook');

    // 調理履歴
    Route::get('/histories', [CookingHistoryController::class, 'index'])->name('histories.index');
    Route::post('/histories', [CookingHistoryController::class, 'store'])->name('histories.store');

    // マイ食材
    Route::get('/my-ingredients', [MyIngredientController::class, 'index'])->name('my-ingredients.index');
    Route::post('/my-ingredients', [MyIngredientController::class, 'store'])->name('my-ingredients.store');
    Route::delete('/my-ingredients/{myIngredient}', [MyIngredientController::class, 'destroy'])->name('my-ingredients.destroy');

    // いいね
    Route::post('/recipes/{recipe}/like', [RecipeLikeController::class, 'toggle'])->name('recipes.like');

    // コメント
    Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // AIチャット
    Route::post('/chat', [ChatController::class, 'ask'])->name('chat.ask');

    // いいねした料理
    Route::get('/liked-recipes', [RecipeLikeController::class, 'index'])->name('liked-recipes.index');

});

// 管理者ルート
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/recipes', [AdminRecipeController::class, 'index'])->name('recipes.index');
    Route::patch('/recipes/{recipe}/toggle', [AdminRecipeController::class, 'toggle'])->name('recipes.toggle');
    Route::delete('/recipes/{recipe}', [AdminRecipeController::class, 'destroy'])->name('recipes.destroy');
});

require __DIR__.'/auth.php';
