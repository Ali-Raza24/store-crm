<?php

use App\Constants\IStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBusinessRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('businesses', function (Blueprint $table){
            $table->tinyInteger('is_active')->after('delivery_company_id')->default(IStatus::BUSINESS_PENDING);
        });
        Schema::table('stores', function (Blueprint $table){
            $table->tinyInteger('is_active')->after('country_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
