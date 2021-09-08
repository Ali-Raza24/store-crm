<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->string('Email');
            $table->string('Name');
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('area_id')->nullable();
            $table->text('address')->nullable();
            $table->string('company_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('zipcode')->nullable();
            $table->tinyInteger('type')->comment('2=billing , 1=shipping');
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
        Schema::dropIfExists('order_addresses');
    }
}
