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
        Schema::create('automation_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('warning_days')->default(3);
            $table->text('warning_message')->nullable();
            $table->integer('cancellation_days')->default(1);
            $table->text('cancellation_message')->nullable();
            $table->boolean('is_automation_enabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automation_settings');
    }
};
