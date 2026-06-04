<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('verification_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('verification_requests', 'verification_type')) {
                $table->enum('verification_type', ['passport', 'id_card', 'both'])->default('passport')->after('status');
            }
            if (!Schema::hasColumn('verification_requests', 'id_card_path')) {
                $table->string('id_card_path')->nullable()->after('passport_path');
            }
            if (!Schema::hasColumn('verification_requests', 'id_card_type')) {
                $table->string('id_card_type')->nullable()->after('id_card_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('verification_requests', function (Blueprint $table) {
            $table->dropColumn(['verification_type', 'id_card_path', 'id_card_type']);
        });
    }
};