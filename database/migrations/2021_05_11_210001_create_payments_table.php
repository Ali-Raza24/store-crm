<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('business_id')->nullable();
            $table->bigInteger('payment_type_id')->nullable();
            $table->bigInteger('payment_method_id')->nullable();
            $table->string('reference_number')->nullable();
            $table->text('payment_data')->nullable();
            $table->decimal('amount')->nullable();
            $table->integer('status');
            $table->tinyInteger('is_paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
