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
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn(['receipt_date', 'signature_path', 'total_amount']);
        });
    }

    /**
     * 
     */
    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn(['type_of_payment', 'remaining_balance', 'total_amount']);
        });
    }
};
