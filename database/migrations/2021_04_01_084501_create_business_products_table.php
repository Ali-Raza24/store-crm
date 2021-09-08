<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('business_id');
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->bigInteger('brand_id');
            $table->decimal('cost_price')->nullable();
            $table->decimal('retail_price');
            $table->decimal('discounted_price')->nullable();
            $table->string('barcode')->nullable();
            $table->string('sku');
            $table->tinyInteger('has_addons_or_variants');
            $table->tinyInteger('is_active')->comment('1=Active, 2=InActive');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_categories', function (Blueprint $table){
            $table->id();
            $table->bigInteger('product_id');
            $table->bigInteger('category_id');
            $table->timestamps();
        });

        Schema::create('product_stores', function (Blueprint $table){
            $table->id();
            $table->bigInteger('product_id');
            $table->bigInteger('store_id');
            $table->timestamps();
        });

        Schema::create('product_variations', function (Blueprint $table){
            $table->id();
            $table->bigInteger('product_id');
            $table->string('title');
            $table->decimal('cost_price')->nullable();
            $table->decimal('retail_price')->nullable();
            $table->decimal('discounted_price')->nullable();
            $table->string('barcode')->nullable();
            $table->string('sku')->nullable();
            $table->timestamps();
        });

        Schema::create('product_addons', function (Blueprint $table){
            $table->id();
            $table->bigInteger('product_id');
            $table->bigInteger('addon_id');
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
        Schema::dropIfExists('products');
    }
}
