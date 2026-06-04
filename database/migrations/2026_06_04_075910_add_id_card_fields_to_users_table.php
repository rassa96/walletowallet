<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'id_card_path')) {
                $table->string('id_card_path')->nullable()->after('passport_path');
            }
            if (!Schema::hasColumn('users', 'id_card_type')) {
                $table->enum('id_card_type', ['passport', 'driving_license', 'national_id', 'other'])->nullable()->after('id_card_path');
            }
            if (!Schema::hasColumn('users', 'id_card_verified')) {
                $table->boolean('id_card_verified')->default(false)->after('is_verified');
            }
            if (!Schema::hasColumn('users', 'id_card_rejection_reason')) {
                $table->text('id_card_rejection_reason')->nullable()->after('rejection_reason');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['id_card_path', 'id_card_type', 'id_card_verified', 'id_card_rejection_reason']);
        });
    }
};