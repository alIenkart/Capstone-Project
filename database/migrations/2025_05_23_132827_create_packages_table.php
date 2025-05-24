<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('tour_duration');
            $table->string('image_path');
            $table->string('itinerary');
            $table->string('exclusions');
            $table->string('package_name');
            $table->integer('capacity');
            $table->boolean('joint_booking');
            $table->string('status');
            $table->double('pax_rate', 8, 2);
            $table->double('discounted_rate', 8, 2);
            $table->string('destination');
            $table->string('terms_condition');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
