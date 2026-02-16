<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->string('sku')->unique()->after('name');
            $table->decimal('price', 10, 2)->default(0)->after('dosage');
            $table->integer('threshold_alert')->default(10)->after('current_stock');
            
            $table->index('sku');
        });
    }

    public function down(): void
    {
        Schema::table('medications', function (Blueprint $table) {
            $table->dropColumn(['sku', 'price', 'threshold_alert']);
        });
    }
};
