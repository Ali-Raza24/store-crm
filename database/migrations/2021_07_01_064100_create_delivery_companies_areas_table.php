<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryCompaniesAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_companies_areas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('delivery_company_id')->nullable();
            $table->bigInteger('state_id')->nullable();
            $table->string('area')->nullable();
            $table->string('location_code')->nullable();
            $table->string('entity')->nullable();
            $table->string('country_code')->nullable();
            $table->string('delivery_company_city')->nullable();
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
        Schema::dropIfExists('delivery_companies_areas');
    }
}
