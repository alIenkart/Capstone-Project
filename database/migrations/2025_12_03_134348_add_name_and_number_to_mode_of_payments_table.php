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
        Schema::table('mode_of_payments', function (Blueprint $table) {
            $table->string('name')->nullable()->after('notes');
            $table->string('number')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mode_of_payments', function (Blueprint $table) {
            $table->dropColumn(['name', 'number']);
        });
    }
};
