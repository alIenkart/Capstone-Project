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
        Schema::table('packages', function (Blueprint $table) {
            if (Schema::hasColumn('packages', 'tour_classification')) {
                $table->dropColumn('tour_classification');
            }

            $table->json('tour_classification')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            if (Schema::hasColumn('packages', 'tour_classification')) {
                $table->dropColumn('tour_classification');
            }

            $table->text('tour_classification')->nullable()->after('description');
        });
    }
};
