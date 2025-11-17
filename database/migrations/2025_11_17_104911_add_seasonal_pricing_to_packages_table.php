<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->boolean('is_seasonal')->default(false);
            $table->decimal('seasonal_pax_rate', 10, 2)->nullable();
            $table->decimal('seasonal_kids_pax_rate', 10, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['is_seasonal', 'seasonal_pax_rate', 'seasonal_kids_pax_rate']);
        });
    }
};
