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
            $table->decimal('adult_extra_fee', 10, 2)->default(0)->nullable()->after('discounted_rate');
            $table->decimal('kids_extra_fee', 10, 2)->default(0)->nullable()->after('adult_extra_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['adult_extra_fee', 'kids_extra_fee']);
        });
    }
};
