<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('admin-dashboard');
        }

        return view('dashboard'); 
    }
    public function manageUsers()
{
    $users = \App\Models\User::where('role', 'user')->get();
    return view('manage-users', compact('users'));
}

public function deleteUser($id)
{
    $user = \App\Models\User::findOrFail($id);
    $user->delete();
    return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
}

}

