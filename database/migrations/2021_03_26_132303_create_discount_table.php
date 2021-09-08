<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id');
            $table->string('code');
            $table->tinyInteger('auto_apply')->nullable();
            $table->tinyInteger('discount_type_id')->default(1)->comment('1=Percentage, 2=Flat');
            $table->decimal('discount_value')->nullable();
            $table->integer('maximum_usage')->nullable();
            $table->tinyInteger('all_products')->default(0)->nullable();
            $table->decimal('minimum_amount')->default(0)->nullable();
            $table->integer('minimum_quantity')->default(0)->nullable();
            $table->date('from_date');
            $table->time('from_time')->nullable();
            $table->date('to_date')->nullable();
            $table->time('to_time')->nullable();
            $table->tinyInteger('is_active')->default(1)->comment('1=Active,2=InActive');
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
        Schema::dropIfExists('discounts');
    }
}
