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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->string('logo', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('banner_image', 255)->nullable();
            $table->text('description')->nullable();
            $table->foreignId('added_by')->nullable()->constrained('admins')->onDelete('set null');//
            $table->foreignId('update_by')->nullable()->constrained('admins')->onDelete('set null');//
            $table->string('status')->default('active')->comment('inactive,active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
