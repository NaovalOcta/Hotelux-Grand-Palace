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
        Schema::create('hotel_profiles', function (Blueprint $table) {
            $table->string('id')->primary(); // HLX-001
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->json('address'); // Menyimpan JSON alamat
            $table->decimal('star_rating', 2, 1);
            $table->text('description_short');
            $table->text('description_long');
            $table->string('hero_image');
            $table->json('key_highlights');
            $table->json('check_in_out_policy');
            $table->json('contact')->nullable();
            $table->json('social_links')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_profiles');
    }
};
