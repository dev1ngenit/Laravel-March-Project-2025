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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('profile_pdf')->nullable();
            $table->longText('content')->nullable();
            $table->string('version')->nullable();
            $table->date('effective_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('status')->default('active')->nullable();
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
        Schema::dropIfExists('about_us');
    }
};
