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
            $table->date('date');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->timestamp('attended_at')->nullable()->useCurrent(); //Bonus field to track when the student attended :D
            $table->timestamps();
            $table->unique(['date', 'student_id']); // Ensure a student can only have one attendance record per day
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
