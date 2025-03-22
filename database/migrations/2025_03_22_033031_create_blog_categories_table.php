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
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('status')->default('active');

            $table->foreignId('added_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('update_by')->nullable()->constrained('admins')->onDelete('set null');

            // $table->unsignedBigInteger('added_by');
            // $table->foreign('added_by')->references('id')->on('admins')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
