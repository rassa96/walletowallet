<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    protected $walletService;
    
    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }
    
    public function dashboard()
    {
        $user = Auth::user();
        
        // Check if user has a wallet, if not create one
        $wallet = $user->wallet;
        
        if (!$wallet) {
            $wallet = $this->walletService->createWallet($user);
        }
        
        // Get transactions - using user_id instead of sender/receiver wallet ids
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('dashboard', compact('user', 'wallet', 'transactions'));
    }
    
    public function showTransferForm()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        
        if (!$wallet) {
            $wallet = $this->walletService->createWallet($user);
        }
        
        return view('transfer', compact('user', 'wallet'));
    }
    
    public function transfer(Request $request)
    {
        $request->validate([
            'receiver_address' => 'required|string|exists:wallets,wallet_address',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
        ]);
        
        try {
            $senderWallet = Auth::user()->wallet;
            
            if (!$senderWallet) {
                throw new \Exception('You don\'t have a wallet. Please contact support.');
            }
            
            $receiverWallet = Wallet::where('wallet_address', $request->receiver_address)->first();
            
            // Prevent sending to self
            if ($senderWallet->id === $receiverWallet->id) {
                return back()->with('error', 'You cannot transfer to your own wallet');
            }
            
            // Create transaction record
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'type' => 'transfer',
                'amount' => $request->amount,
                'description' => $request->description ?? 'Transfer to ' . $receiverWallet->wallet_address,
                'status' => 'completed',
                'reference' => 'TXN_' . time() . '_' . Auth::id(),
            ]);
            
            // Update balances
            $senderWallet->balance -= $request->amount;
            $senderWallet->save();
            
            $receiverWallet->balance += $request->amount;
            $receiverWallet->save();
            
            return redirect()->route('wallet.dashboard')
                ->with('success', "Successfully transferred {$request->amount} to {$request->receiver_address}");
                
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function getBalance()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        
        if (!$wallet) {
            return response()->json(['balance' => 0, 'error' => 'No wallet found']);
        }
        
        return response()->json(['balance' => $wallet->balance]);
    }
}