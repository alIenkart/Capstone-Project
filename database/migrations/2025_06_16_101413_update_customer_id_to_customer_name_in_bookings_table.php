<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
            $table->dropColumn('booking_date');

            $table->string('customer_name')->after('package_id');
            $table->string('status')->default('Pending')->after('customer_name');
            $table->string('id_type')->nullable()->after('status');
            $table->text('remarks')->nullable()->after('id_type');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('customer_name');

            $table->unsignedBigInteger('customer_id')->after('package_id');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
