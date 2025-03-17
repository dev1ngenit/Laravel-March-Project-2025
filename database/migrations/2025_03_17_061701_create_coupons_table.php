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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');

            $table->string('badge')->nullable();
            $table->string('name')->unique()->nullable();
            $table->string('slug')->unique()->nullable();

            $table->double('price')->nullable();
            $table->double('offer_price')->nullable();

            $table->longText('description')->nullable();
            $table->longText('locations')->nullable();

            $table->text('url')->nullable();
            $table->text('source_url')->nullable();
            $table->text('map_url')->nullable();

            $table->string('coupon_code')->nullable();

            $table->timestamp('start_date')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->timestamp('notification_date')->nullable();

            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
