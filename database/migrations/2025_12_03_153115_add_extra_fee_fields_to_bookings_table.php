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
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('extra_days')->default(0)->after('duration');
            $table->decimal('adult_extra_fee', 10, 2)->default(0)->after('adult_total_amount');
            $table->decimal('kids_extra_fee', 10, 2)->default(0)->after('kids_total_amount');
            $table->decimal('total_extra_fee', 10, 2)->default(0)->after('kids_extra_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['extra_days', 'adult_extra_fee', 'kids_extra_fee', 'total_extra_fee']);
        });
    }
};
