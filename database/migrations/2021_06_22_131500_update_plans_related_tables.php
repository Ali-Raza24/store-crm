<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePlansRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_options', function (Blueprint $table) {
            $table->dropColumn('option_id');
            $table->string('option')->nullable()->after('plan_id');
            $table->string('option_text')->nullable()->after('values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_options', function (Blueprint $table) {
            $table->bigInteger('option_id');
            $table->dropColumn(['option', 'option_text']);
        });
    }
}
