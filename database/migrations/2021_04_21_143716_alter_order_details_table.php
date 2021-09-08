<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrderDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->bigInteger('product_variation_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->bigInteger('product_variation_id')->change();
        });
    }
}
