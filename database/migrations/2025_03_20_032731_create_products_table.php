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
            // Relationships
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('sub_category_id')->nullable()->constrained('categories')->onDelete('set null');
            // $table->json('category_id')->nullable(); // For multi-category support
            // Basic Info
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('sku_code')->nullable();
            $table->string('mf_code')->nullable();
            $table->string('product_code')->nullable();
            $table->string('barcode_id')->nullable();
            $table->string('barcode')->nullable();
            // Descriptions
            $table->text('short_description')->nullable();
            $table->longText('overview')->nullable();
            $table->longText('long_description')->nullable(); // Alias of "description"
            $table->longText('specification')->nullable();
            // Multimedia
            $table->string('thumbnail', 255)->nullable(); // Primary image
            $table->string('thumbnail_image_2', 255)->nullable(); // Secondary image
            $table->text('video_link')->nullable();
            // Tags and attributes
            $table->json('tags')->nullable();
            $table->json('color')->nullable();
            // Stock & Inventory
            $table->integer('stock')->nullable(); // Total available stock
            // Pricing
            $table->double('price')->default(0.00);
            $table->double('partner_price', 10, 2)->nullable();
            $table->double('discount_price', 10, 2)->nullable(); // General-purpose discount
            // Tax & Warranty
            $table->double('vat')->nullable();
            $table->double('tax')->nullable();
            $table->string('warranty')->nullable();
            // Dimensions & Weight
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('weight')->nullable();
            // Location & Supplier
            $table->string('supplier')->nullable();
            $table->string('warehouse_location')->nullable();
            // Flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_selling')->default(false);
            $table->boolean('is_refurbished')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('hot_deal')->default(false);
            // $table->string('is_refurbished', 10)->nullable(); // e.g. "yes" or "no"
            // Rating & Status
            $table->integer('rating')->nullable();
            $table->enum('status', ['published', 'draft', 'inactive', 'active'])->default('published');
            $table->string('product_type')->nullable(); // e.g. 'accessory', 'bundle'
            // SEO
            $table->string('meta_title')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->string('meta_keyword')->nullable(); // Keep for backward compatibility
            $table->text('meta_content')->nullable();
            $table->longText('meta_description')->nullable();
            // Admin tracking
            $table->foreignId('added_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->string('created_by')->nullable(); // for string-based fallback
            $table->date('create_date')->nullable();

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
