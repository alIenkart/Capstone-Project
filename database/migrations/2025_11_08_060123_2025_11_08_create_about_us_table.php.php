<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->text('why_choose_us')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // Create default About Us record
        DB::table('about_us')->insert([
            'title' => 'About Us',
            'subtitle' => 'Get to know our story',
            'mission' => 'Our mission text here',
            'vision' => 'Our vision text here',
            'why_choose_us' => 'Why choose us text here',
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};