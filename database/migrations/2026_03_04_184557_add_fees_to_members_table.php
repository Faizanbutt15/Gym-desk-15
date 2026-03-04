<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->decimal('admission_fee', 8, 2)->default(0)->after('fee_amount');
            $table->decimal('trainer_fee', 8, 2)->default(0)->after('admission_fee');
            $table->decimal('locker_fee', 8, 2)->default(0)->after('trainer_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['admission_fee', 'trainer_fee', 'locker_fee']);
        });
    }
};
