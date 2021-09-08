<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_email')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('owner_mobile')->nullable();
            $table->string('brand_color')->nullable();
            $table->integer('total_stores')->nullable();
            $table->decimal('minimum_order_amount')->nullable();
            $table->string('url')->nullable();
            $table->bigInteger('business_type_id')->nullable();
            $table->bigInteger('plan_id')->nullable();
            $table->tinyInteger('business_status_id')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
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
        Schema::dropIfExists('businesses');
    }
}
