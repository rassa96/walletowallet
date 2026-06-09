<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletFundingController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function showTopUp()
    {
        $user = Auth::user();
        
        if (!$user->is_verified) {
            return redirect()->route('user.verification')
                ->with('error', 'You have to verify your account before you can top up your wallet. Please upload your passport or ID card.');
        }
        
        $wallet = $user->wallet;
        
        return view('topup', compact('user', 'wallet'));
    }
    
    public function processTopUp(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->is_verified) {
            return redirect()->route('home')
                ->with('error', 'You must verify your account before topping up.');
        }
        
        $request->validate([
            'amount' => 'required|numeric|min:1|max:100000',
        ]);
        
        $wallet = $user->wallet;
        
        if (!$wallet) {
            return back()->with('error', 'Wallet not found. Please contact support.');
        }
        
        // Add balance
        $wallet->balance += $request->amount;
        $wallet->save();
        
        $reference = 'TOPUP_' . time() . '_' . $user->id;

        // Create transaction record
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'deposit',
            'amount' => $request->amount,
            'description' => 'Wallet top up',
            'status' => 'completed',
            'reference' => $reference,
        ]);

        $this->notificationService->walletTopUp($user, (float) $request->amount, $reference);
        
        return redirect()->route('home')
            ->with('success', 'Successfully topped up $' . number_format($request->amount, 2) . ' to your wallet!');
    }
}
