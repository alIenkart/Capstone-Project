<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('approved_by');

            $table->date('receipt_date');
            $table->double('total_amount', 10, 2);
            $table->string('signature_path');

            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};