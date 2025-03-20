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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('slug')->unique();

            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');

            $table->string('thumbnail_image')->nullable();
            $table->string('sku')->nullable();
            $table->string('mf_code')->nullable();

            $table->longText('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->longText('specification')->nullable();

            $table->integer('qty')->nullable();
            $table->string('currency')->nullable();
            $table->double('price', 10, 2)->default(0.00);
            $table->double('discount_price', 10, 2)->nullable();

            $table->string('supplier')->nullable();
            $table->string('warehouse_location')->nullable();
            $table->string('weight')->nullable();
            $table->string('tags')->nullable();

            $table->boolean('is_featured')->default(0);
            $table->boolean('is_selling')->default(0);
            $table->boolean('is_new')->default(0);
            $table->boolean('hot_deal')->default(0);

            $table->string('status')->default('active');

            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->text('meta_content')->nullable();
            $table->longText('meta_description')->nullable();

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
        Schema::dropIfExists('products');
    }
};
