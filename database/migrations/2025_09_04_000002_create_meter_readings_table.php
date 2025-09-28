<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meter_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('plumber_id')->constrained('users')->onDelete('cascade');
            $table->date('reading_date');
            $table->decimal('previous_reading', 12, 4);
            $table->decimal('present_reading', 12, 4);
            $table->decimal('used_cubic_meters', 12, 4);
            $table->enum('period', ['mid', 'end']); // 15th or 30th
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meter_readings');
    }
};



