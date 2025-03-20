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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();                              //
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //

            $table->string('order_number')->nullable();
            $table->string('invoice_number')->nullable();

            $table->string('billing_name')->nullable();          //
            $table->string('billing_address_line1')->nullable(); //
            $table->string('billing_address_line2')->nullable();
            $table->string('billing_city')->nullable();        //
            $table->string('billing_state')->nullable();       //
            $table->string('billing_postal_code')->nullable(); //
            $table->string('billing_country')->nullable();     //
            $table->string('billing_phone')->nullable();       //
            $table->string('billing_email')->nullable();       //

            $table->string('shipping_name')->nullable();
            $table->string('shipping_address_line1')->nullable();
            $table->string('shipping_address_line2')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_postal_code')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('shipping_phone')->nullable();

            $table->string('shipping_charge', 10, 2); //

            $table->string('payment_method')->nullable();     //
            $table->string('transaction_number')->nullable(); //
            $table->string('total_amount', 10, 2);            //

            $table->text('notes')->nullable();
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');

            $table->string('order_date')->nullable();  //
            $table->string('order_month')->nullable(); //
            $table->string('order_year')->nullable();  //
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'return'])->default('pending');

            $table->string('processing_date')->nullable();
            $table->string('shipped_date')->nullable();
            $table->string('delivered_date')->nullable();
            $table->string('return_date')->nullable();

            $table->text('return_reason')->nullable();
            $table->string('return_amount', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
