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
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'remaining_payment')) {
                $table->dropColumn('remaining_payment');
            }
            if (Schema::hasColumn('payments', 'amount_paid')) {
                $table->dropColumn('amount_paid');
            }
            if (Schema::hasColumn('payments', 'payment_date')) {
                $table->dropColumn('payment_date');
            }

            $table->json('payment_history')->nullable()->after('booking_id');
            $table->string('remarks')->nullable()->after('payment_history');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_history');

            $table->decimal('remaining_payment', 10, 2)->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->date('payment_date')->nullable();
        });
    }
};
