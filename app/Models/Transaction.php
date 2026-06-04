<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'sender_wallet_id',
        'receiver_wallet_id',
        'reference',
        'amount',
        'fee',
        'status',
        'description',
        'type',
        'completed_at'
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'completed_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}