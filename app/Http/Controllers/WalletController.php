<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction;
use App\Services\NotificationService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    protected $walletService;
    protected $notificationService;
    
    public function __construct(WalletService $walletService, NotificationService $notificationService)
    {
        $this->walletService = $walletService;
        $this->notificationService = $notificationService;
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
        
        if (!$user->is_verified) {
            return redirect()->route('user.verification')
                ->with('error', 'You have to verify your account before you can make transfers.');
        }
        
        $wallet = $user->wallet;
        
        if (!$wallet) {
            $wallet = $this->walletService->createWallet($user);
        }
        
        return view('transfer', compact('user', 'wallet'));
    }
    
    public function transfer(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->is_verified) {
            return redirect()->route('user.verification')
                ->with('error', 'You have to verify your account before you can make transfers.');
        }
        
        $request->validate([
            'receiver_address' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
        ]);
        
        try {
            $senderWallet = $user->wallet;
            
            if (!$senderWallet) {
                throw new \Exception('You don\'t have a wallet. Please contact support.');
            }
            
            $receiverWallet = Wallet::where('wallet_address', $request->receiver_address)->first();
            
            if (!$receiverWallet) {
                return back()->with('error', 'Wallet address not found. Please check and try again.');
            }
            
            // Prevent sending to self
            if ($senderWallet->id === $receiverWallet->id) {
                return back()->with('error', 'You cannot transfer to your own wallet.');
            }
            
            // Check sufficient balance
            if ($senderWallet->balance < $request->amount) {
                return back()->with('error', 'Insufficient balance. Your current balance is $' . number_format($senderWallet->balance, 2));
            }
            
            // Check receiver is verified
            $receiver = $receiverWallet->user;
            if (!$receiver->is_verified) {
                return back()->with('error', 'The recipient account is not verified and cannot receive transfers.');
            }
            
            $reference = 'TXN_' . time() . '_' . $user->id;
            
            // Create sender transaction record
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'transfer',
                'amount' => $request->amount,
                'description' => $request->description ?? 'Transfer to ' . $receiver->name,
                'status' => 'completed',
                'reference' => $reference,
            ]);
            
            // Create receiver transaction record
            Transaction::create([
                'user_id' => $receiver->id,
                'type' => 'deposit',
                'amount' => $request->amount,
                'description' => 'Received from ' . $user->name,
                'status' => 'completed',
                'reference' => $reference . '_R',
            ]);
            
            // Update balances
            $senderWallet->balance -= $request->amount;
            $senderWallet->save();
            
            $receiverWallet->balance += $request->amount;
            $receiverWallet->save();

            $this->notificationService->moneySent($user, (float) $request->amount, $receiver->name, $reference);
            $this->notificationService->moneyReceived($receiver, (float) $request->amount, $user->name, $reference);
            
            return redirect()->route('home')
                ->with('success', 'Successfully transferred $' . number_format($request->amount, 2) . ' to ' . $receiver->name);
                
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
