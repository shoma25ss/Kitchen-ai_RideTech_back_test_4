<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // ユーザー一覧
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    // ユーザー削除
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', '自分自身は削除できません。');
        }

        $user->delete();

        return back()->with('success', 'ユーザーを削除しました。');
    }
}
