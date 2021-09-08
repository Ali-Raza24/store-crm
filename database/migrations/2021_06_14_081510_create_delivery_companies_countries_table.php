<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryCompaniesCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_companies_countries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('delivery_company_id');
            $table->string('code', 2);
            $table->string('name');
            $table->string('iso_code', 3);
            $table->boolean('state_required')->default(false);
            $table->boolean('post_code_required')->default(false);
            $table->string('internation_calling_number');
            $table->timestamp('last_fetched_at');
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
        Schema::dropIfExists('delivery_companies_countries');
    }
}
