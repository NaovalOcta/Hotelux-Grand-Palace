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
        Schema::create('room_types', function (Blueprint $table) {
            $table->string('id')->primary(); // deluxe-king-city
            $table->string('name');
            $table->text('description');
            $table->json('gallery_images');
            $table->json('occupancy');
            $table->integer('size_m2');
            $table->string('view_type');
            $table->string('bed_type');
            $table->integer('total_inventory');
            $table->json('amenities');
            $table->json('rate_plans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
