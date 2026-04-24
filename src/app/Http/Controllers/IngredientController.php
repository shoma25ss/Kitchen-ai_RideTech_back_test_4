<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyIngredient;

class IngredientController extends Controller
{
    // 食材入力画面
    public function index()
    {
        $myIngredients = auth()->user()->myIngredients()->get();
        return view('ingredients.input', compact('myIngredients'));
    }
}
