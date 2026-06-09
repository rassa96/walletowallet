<?php

namespace App\Services;

use App\Models\NotificationLog;
use App\Models\User;

class NotificationService
{
    public function moneySent(User $user, float $amount, string $recipientName, ?string $reference = null): NotificationLog
    {
        return NotificationLog::create([
            'user_id' => $user->id,
            'type' => 'money_sent',
            'title' => 'Money Sent',
            'message' => 'You sent $' . number_format($amount, 2) . ' to ' . $recipientName . '.',
            'amount' => $amount,
            'metadata' => ['reference' => $reference],
        ]);
    }

    public function moneyReceived(User $user, float $amount, string $senderName, ?string $reference = null): NotificationLog
    {
        return NotificationLog::create([
            'user_id' => $user->id,
            'type' => 'money_received',
            'title' => 'Money Received',
            'message' => 'You received $' . number_format($amount, 2) . ' from ' . $senderName . '.',
            'amount' => $amount,
            'metadata' => ['reference' => $reference],
        ]);
    }

    public function walletTopUp(User $user, float $amount, ?string $reference = null): NotificationLog
    {
        return NotificationLog::create([
            'user_id' => $user->id,
            'type' => 'wallet_top_up',
            'title' => 'Wallet Top Up',
            'message' => 'You added $' . number_format($amount, 2) . ' to your wallet.',
            'amount' => $amount,
            'metadata' => ['reference' => $reference],
        ]);
    }
}
