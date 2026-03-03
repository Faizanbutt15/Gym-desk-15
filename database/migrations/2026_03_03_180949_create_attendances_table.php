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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gym_id')->constrained()->cascadeOnDelete();
            $table->string('user_type'); // 'member' or 'staff'
            $table->unsignedBigInteger('user_id'); // ID of the member or staff record
            $table->date('date');
            $table->time('time_in');
            $table->timestamps();
            
            // Allow only one attendance record per person per day
            $table->unique(['gym_id', 'user_type', 'user_id', 'date'], 'attendance_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
