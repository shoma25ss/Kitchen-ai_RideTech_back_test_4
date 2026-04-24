<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Recipe;
use App\Models\CookingHistory;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount    = User::count();
        $recipeCount  = Recipe::count();
        $historyCount = CookingHistory::count();

        // 月別レシピ生成数（直近6ヶ月）
        $monthlyData = Recipe::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'userCount', 'recipeCount', 'historyCount', 'monthlyData'
        ));
    }
}
