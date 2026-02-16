<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['doctor', 'patient', 'admin'])->default('patient')->after('password');
            $table->string('profile_photo_path')->nullable()->after('role');
            $table->string('mrn')->unique()->nullable()->after('profile_photo_path'); // Medical Record Number
            $table->string('diagnosis')->nullable()->after('mrn');
            
            $table->index('role');
            $table->index('mrn');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'profile_photo_path', 'mrn', 'diagnosis']);
        });
    }
};
