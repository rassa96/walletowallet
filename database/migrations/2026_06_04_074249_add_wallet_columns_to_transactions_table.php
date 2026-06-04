<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'sender_wallet_id')) {
                $table->foreignId('sender_wallet_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('transactions', 'receiver_wallet_id')) {
                $table->foreignId('receiver_wallet_id')->nullable()->after('sender_wallet_id');
            }
            if (!Schema::hasColumn('transactions', 'reference')) {
                $table->string('reference')->unique()->nullable()->after('amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['sender_wallet_id', 'receiver_wallet_id', 'reference']);
        });
    }
};