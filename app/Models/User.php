<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'profile_image', 'passport_path', 'is_verified', 'verified_at', 'rejection_reason', 'id_card_path', 'id_card_type', 'id_card_verified', 'id_card_rejection_reason', 'is_admin', 'is_blocked'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


        // Add this relationship
    public function verificationRequests()
    {
        return $this->hasMany(VerificationRequest::class);
    }

    public function latestVerificationRequest()
    {
        return $this->hasOne(VerificationRequest::class)->latest();
    }

    public function isVerified()
    {
        return (bool) $this->is_verified;
    }

    public function canTransact()
    {
        return $this->is_verified && !$this->is_blocked;
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function notificationLogs()
    {
        return $this->hasMany(NotificationLog::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    }
