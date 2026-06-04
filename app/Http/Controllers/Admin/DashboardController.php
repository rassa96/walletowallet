<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Simple test response first
        return "Admin Dashboard - Working!";
        
        // Later replace with actual view
        /*
        $stats = [
            'total_users' => User::count(),
            'verified_users' => User::where('is_verified', true)->count(),
            'pending_verifications' => User::where('is_verified', false)->whereNotNull('passport_path')->count(),
            'total_transactions' => Transaction::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
        */
    }
}