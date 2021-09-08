<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStoreZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_zones', function (Blueprint $table) {
           $table->string('hours', 5)->nullable()->change();
           $table->string('minutes', 5)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_zones', function (Blueprint $table) {
            $table->integer('hours')->nullable()->change();
            $table->integer('minutes')->nullable()->change();
        });
    }
}
