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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->foreignId('blog_category_id')->nullable()->constrained('blog_categories')->onDelete('set null');
            $table->date('date')->nullable();

            $table->string('thumbnail_image')->nullable();

            $table->text('short_description')->nullable();
            $table->string('image_one')->nullable();
            $table->longText('long_description_one')->nullable();
            $table->string('image_two')->nullable();
            $table->longText('long_description_two')->nullable();
            $table->string('video')->nullable();
            $table->text('video_description')->nullable();

            $table->string('author_name')->nullable();
            $table->string('author_image')->nullable();
            $table->string('quote')->nullable();

            $table->boolean('is_featured')->default(0);

            $table->string('meta_title')->nullable();
            $table->string('meta_tags')->nullable();
            $table->longText('meta_description')->nullable();

            $table->string('tags')->nullable();

            $table->string('status')->default('active');

            $table->foreignId('added_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('update_by')->nullable()->constrained('admins')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
