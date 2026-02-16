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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medication_id')->constrained()->onDelete('cascade');
            $table->enum('time_period', ['morning', 'afternoon', 'evening', 'night']);
            $table->time('scheduled_time'); // Exact time like 08:00:00
            $table->json('days_of_week'); // [1,2,3,4,5,6,7] for Mon-Sun
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('medication_id');
            $table->index(['time_period', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
