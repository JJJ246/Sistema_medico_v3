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
        Schema::create('adherence_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medication_id')->constrained()->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->date('log_date');
            $table->enum('status', ['taken', 'pending', 'missed', 'snoozed']);
            $table->timestamp('taken_at')->nullable();
            $table->timestamp('snoozed_until')->nullable();
            $table->timestamps();
            
            $table->unique(['medication_id', 'schedule_id', 'log_date']);
            $table->index(['log_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adherence_logs');
    }
};
