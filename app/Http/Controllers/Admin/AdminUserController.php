<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
        }

        $users = $query->latest()->paginate(15);

        $users->each(function ($user) {
            $user->lastOrder = $user->orders()->latest()->first();
        });

        $totalUsers = User::count();
        $activeUsers = User::has('orders')->count();
        $adminCount = User::where('is_admin', true)->count();

        return view('admin.users.index', compact('users', 'totalUsers', 'activeUsers', 'adminCount'));
    }

    public function show($id)
    {
        $user = User::with('orders')->withCount('orders')->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        if ($id == Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    public function toggleAdmin($id)
    {
        if ($id == Auth::id()) {
            return back()->with('error', 'Tidak bisa mengubah role sendiri.');
        }
        $user = User::findOrFail($id);
        $user->update(['is_admin' => ! $user->is_admin]);

        return back()->with('success', 'Role pengguna berhasil diubah.');
    }
}
