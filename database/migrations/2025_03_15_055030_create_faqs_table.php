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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();

            $table->string('question')->nullable();
            $table->text('answer')->nullable();
            $table->string('tag')->nullable();
            $table->integer('order')->default(0);
            $table->integer('views')->default(0)->nullable();
            $table->text('additional_info')->nullable();
            $table->string('status')->default('inactive')->comment('inactive,active');

            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
