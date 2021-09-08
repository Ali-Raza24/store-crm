<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_zones', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->bigInteger('business_id');
            $table->bigInteger('store_id');
            $table->bigInteger('delivery_company_id')->default(0);
            $table->decimal('charges')->nullable();
            $table->integer('days')->nullable();
            $table->integer('hours')->nullable();
            $table->integer('minutes')->nullable();
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
        Schema::dropIfExists('store_zones');
    }
}
