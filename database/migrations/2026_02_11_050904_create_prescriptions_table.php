<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('medication_id')->constrained()->onDelete('cascade');
            $table->string('frequency'); // 'q8h', 'q12h', 'daily', 'bid', 'tid', etc.
            $table->integer('duration_days');
            $table->integer('total_quantity'); // Calculated: (24/hours) * duration_days
            $table->text('instructions')->nullable();
            $table->timestamp('issued_at')->useCurrent();
            $table->timestamps();
            
            $table->index(['doctor_id', 'patient_id']);
            $table->index('issued_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
