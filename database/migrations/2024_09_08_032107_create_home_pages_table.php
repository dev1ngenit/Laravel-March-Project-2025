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
        Schema::create('home_pages', function (Blueprint $table) {
            $table->id();

            $table->string('top_banner')->nullable();
            $table->text('top_banner_link')->nullable();

            $table->string('deal_title')->nullable();
            $table->string('deal_header')->nullable();
            $table->foreignId('deal_brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->string('deal_brand_image')->nullable();

            $table->string('offer_slider_image_one')->nullable();
            $table->string('offer_slider_image_two')->nullable();
            $table->string('offer_slider_image_three')->nullable();
            $table->string('offer_slider_image_four')->nullable();

            $table->string('bottom_banner_slider_one')->nullable();
            $table->text('bottom_banner_slider_one_link')->nullable();

            $table->string('bottom_banner_slider_two')->nullable();
            $table->text('bottom_banner_slider_two_link')->nullable();

            $table->string('bottom_banner_slider_three')->nullable();
            $table->text('bottom_banner_slider_three_link')->nullable();

            $table->string('bottom_banner_slider_four')->nullable();
            $table->text('bottom_banner_slider_four_link')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_pages');
    }
};
