<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('tour_duration');
            $table->date('end_date')->nullable()->after('start_date');
            $table->dropColumn('joint_booking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);
            $table->boolean('joint_booking')->default(false);
        });
    }
};
