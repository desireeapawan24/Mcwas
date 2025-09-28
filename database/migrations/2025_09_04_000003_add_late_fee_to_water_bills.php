<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('water_bills', function (Blueprint $table) {
            $table->decimal('late_fee', 10, 2)->default(0)->after('balance');
            $table->boolean('late_fee_applied')->default(false)->after('late_fee');
        });
    }

    public function down(): void
    {
        Schema::table('water_bills', function (Blueprint $table) {
            $table->dropColumn(['late_fee', 'late_fee_applied']);
        });
    }
};



