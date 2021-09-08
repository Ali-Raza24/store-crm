<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProductPriceValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('retail_price', 50,2)->nullable()->default(0)->change();
            $table->decimal('cost_price', 50,2)->nullable()->default(0)->change();
            $table->decimal('discounted_price', 50,2)->nullable()->default(0)->change();
        });

        Schema::table('product_variations', function (Blueprint $table) {
            $table->decimal('retail_price', 50,2)->nullable()->default(0)->change();
            $table->decimal('cost_price', 50,2)->nullable()->default(0)->change();
            $table->decimal('discounted_price', 50,2)->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
