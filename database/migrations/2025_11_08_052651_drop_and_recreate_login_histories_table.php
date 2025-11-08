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
        Schema::dropIfExists('login_histories');
        
        Schema::create('login_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('email');
            $table->timestamp('logged_in_at');
            $table->timestamps();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
                
            $table->index('user_id');
            $table->index('logged_in_at');
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down()
     {
         Schema::dropIfExists('login_histories');
     }
};
