<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable();
            $table->string('rejection_category')->nullable()->after('rejection_reason');
            $table->timestamp('rejected_at')->nullable()->after('rejection_category');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['rejection_reason', 'rejection_category', 'rejected_at']);
        });
    }
};
