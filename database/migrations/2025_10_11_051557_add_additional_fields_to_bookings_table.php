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
            // Package details
            $table->string('package_destination')->nullable()->after('customer_name');
            $table->string('tour_type')->nullable()->after('package_destination');
            $table->integer('duration')->nullable()->after('tour_type');
            $table->date('start_date')->nullable()->after('duration');
            $table->date('end_date')->nullable()->after('start_date');
            
            // Pricing details
            $table->integer('adults_quantity')->nullable()->after('total_price');
            $table->integer('kids_quantity')->nullable()->after('adults_quantity');
            $table->decimal('adult_rate', 10, 2)->nullable()->after('kids_quantity');
            $table->decimal('kids_rate', 10, 2)->nullable()->after('adult_rate');
            $table->decimal('adult_total_amount', 10, 2)->nullable()->after('kids_rate');
            $table->decimal('kids_total_amount', 10, 2)->nullable()->after('adult_total_amount');
            $table->decimal('original_amount', 10, 2)->nullable()->after('kids_total_amount');
            
            // Customer contact details
            $table->string('customer_email')->nullable()->after('customer_name');
            $table->string('customer_phone')->nullable()->after('customer_email');
            $table->text('customer_address')->nullable()->after('customer_phone');
            
            // Additional fields
            $table->text('discount_images')->nullable()->after('discount_id_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'package_destination',
                'tour_type',
                'duration',
                'start_date',
                'end_date',
                'adults_quantity',
                'kids_quantity',
                'adult_rate',
                'kids_rate',
                'adult_total_amount',
                'kids_total_amount',
                'original_amount',
                'customer_email',
                'customer_phone',
                'customer_address',
                'discount_images'
            ]);
        });
    }
};