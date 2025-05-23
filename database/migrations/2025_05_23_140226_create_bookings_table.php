<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->unsignedBigInteger('voucher_id')->nullable();

            $table->integer('total_quantity');
            $table->double('total_price', 10, 2);
            $table->date('booking_date');

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('set null');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};