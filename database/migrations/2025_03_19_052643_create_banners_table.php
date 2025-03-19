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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();

            $table->string('badge')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->string('button_name')->nullable();
            $table->string('status')->default('active');

            $table->foreignId('added_by')->nullable()->constrained('admins')->onDelete('set null');  //
            $table->foreignId('update_by')->nullable()->constrained('admins')->onDelete('set null'); //

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
