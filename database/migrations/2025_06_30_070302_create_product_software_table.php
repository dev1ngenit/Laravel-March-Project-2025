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
        Schema::create('product_software', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('version')->nullable();
            $table->string('license_key')->nullable();
            $table->string('download_link')->nullable();
            $table->text('description')->nullable();
            $table->string('file_size')->nullable();
            $table->string('file_type')->nullable();
            $table->date('release_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_software');
    }
};
