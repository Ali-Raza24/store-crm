<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->bigInteger('customer_id');
            $table->bigInteger('store_id');
            $table->bigInteger('business_id');
            $table->string('subtotal');
            $table->string('discount_code')->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('discount_value')->nullable();
            $table->decimal('discount')->nullable();
            $table->decimal('tax')->default(0);
            $table->decimal('total');
            $table->decimal('refunded_amount')->nullable();
            $table->text('refund_reason')->nullable();
            $table->decimal('delivery_charges')->nullable();
            $table->integer('delivery_company_id')->default(0);
            $table->tinyInteger('is_gift')->default(0);
            $table->text('customer_notes')->nullable();
            $table->integer('payment_type_id')->nullable();
            $table->integer('payment_method_id')->nullable();
            $table->integer('payment_status_id')->nullable();
            $table->integer('fulfilment_status_id')->nullable();
            $table->integer('order_status_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
