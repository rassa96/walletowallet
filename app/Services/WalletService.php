<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WalletService
{
    public function createWallet($user, $currency = 'USD'): Wallet
    {
        return Wallet::create([
            'user_id' => $user->id,
            'wallet_address' => $this->generateWalletAddress(),
            'currency' => $currency,
            'balance' => 0,
            'is_active' => true,
        ]);
    }
    
    public function transfer(Wallet $senderWallet, Wallet $receiverWallet, float $amount, $description = null): Transaction
    {
        if ($senderWallet->balance < $amount) {
            throw new \Exception('Insufficient balance. Available: ' . $senderWallet->balance);
        }
        
        if (!$senderWallet->is_active || !$receiverWallet->is_active) {
            throw new \Exception('One or both wallets are inactive');
        }
         {
        // Check if sender is verified
        if (!$senderWallet->user->isVerified()) {
            throw new \Exception('Your account is not verified. Please upload your passport and wait for admin approval before sending money.');
        }
        
        // Rest of your transfer logic...
        if ($senderWallet->balance < $amount) {
            throw new \Exception('Insufficient balance. Available: ' . $senderWallet->balance);
        }
        
        // ... rest of the code
    }
        
        $reference = $this->generateReference();
        
        return DB::transaction(function () use ($senderWallet, $receiverWallet, $amount, $description, $reference) {
            // Lock wallets to prevent race conditions
            $sender = Wallet::where('id', $senderWallet->id)->lockForUpdate()->first();
            $receiver = Wallet::where('id', $receiverWallet->id)->lockForUpdate()->first();
            
            // Deduct from sender
            $sender->balance -= $amount;
            $sender->save();
            
            // Add to receiver
            $receiver->balance += $amount;
            $receiver->save();
            
            // Create transaction record
            return Transaction::create([
                'sender_wallet_id' => $sender->id,
                'receiver_wallet_id' => $receiver->id,
                'reference' => $reference,
                'amount' => $amount,
                'status' => 'completed',
                'description' => $description,
                'type' => 'transfer',
                'completed_at' => now(),
            ]);
        });
    }
    
    private function generateWalletAddress(): string
    {
        do {
            $address = 'WLT_' . Str::upper(Str::random(12));
        } while (Wallet::where('wallet_address', $address)->exists());
        
        return $address;
    }
    
    private function generateReference(): string
    {
        do {
            $reference = 'TXN_' . date('Ymd') . '_' . Str::upper(Str::random(10));
        } while (Transaction::where('reference', $reference)->exists());
        
        return $reference;
    }


    
}