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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique()->nullable();
            $table->string('name', 150)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('subject', 255)->nullable();
            $table->longText('message')->nullable();

            $table->longText('response')->nullable();

            $table->string('ip_address', 100)->nullable();
            $table->enum('status', ['pending', 'replied', 'on_going', 'closed'])->default('pending');
            $table->string('attachment')->nullable();
            $table->boolean('call')->default(0)->nullable()->comment('0 for inactive, 1 for active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
