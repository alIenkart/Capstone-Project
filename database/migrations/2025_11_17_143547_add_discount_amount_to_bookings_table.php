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
            $table->decimal('discount_amount', 10, 2)
                  ->nullable()
                  ->after('total_price')
                  ->comment('Discounted amount applied');

            $table->unsignedTinyInteger('discount_percent')
                  ->nullable()
                  ->after('discount_amount')
                  ->comment('Discount percentage applied');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['discount_amount', 'discount_percent']);
        });
    }
};
