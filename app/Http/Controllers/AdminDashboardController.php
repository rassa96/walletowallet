<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (auth()->user()->is_admin != 1) {
            abort(403, 'Access denied. Admin only.');
        }
        
        $stats = [
            'total_users' => User::count(),
            'verified_users' => User::where('is_verified', true)->count(),
            'unverified_users' => User::where('is_verified', false)->count(),
            'total_transactions' => Transaction::count(),
        ];
        
        $recent_users = User::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recent_users'));
    }
}