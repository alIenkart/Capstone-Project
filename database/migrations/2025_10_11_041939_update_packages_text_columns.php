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
        Schema::table('packages', function (Blueprint $table) {
            // Change string columns to text to allow longer content
            $table->text('description')->change();
            $table->text('itinerary')->change();
            $table->text('exclusions')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            // Revert back to string columns
            $table->string('description')->change();
            $table->string('itinerary')->change();
            $table->string('exclusions')->change();
        });
    }
};
