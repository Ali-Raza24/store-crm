<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAddonsTable extends Migration
{
    public function up()
    {
        Schema::create('order_addons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->bigInteger('addon_id');
            $table->decimal('price');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_addons');
    }
}
