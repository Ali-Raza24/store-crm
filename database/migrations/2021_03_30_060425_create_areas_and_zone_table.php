<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasAndZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('business_store_areas');
        Schema::dropIfExists('zone_areas');
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->bigInteger('state_id');
            $table->bigInteger('delivery_company_id')->default('0');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('business_areas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('business_id');
            $table->bigInteger('area_id');
            $table->timestamps();
        });
        Schema::create('zone_areas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('zone_id');
            $table->bigInteger('area_id');
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
        Schema::dropIfExists('areas');
        Schema::dropIfExists('business_areas');
        Schema::dropIfExists('zone_areas');
    }
}
