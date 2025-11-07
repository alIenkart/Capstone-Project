<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->default('Travel Blog Page'); // 'Home Page' or 'Travel Blog Page'
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Create the fixed Introduction record
        DB::table('contents')->insert([
            'title' => 'INTRODUCTION',
            'subtitle' => 'Home Page',
            'image' => null,
            'description' => 'Welcome to our homepage introduction!',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};