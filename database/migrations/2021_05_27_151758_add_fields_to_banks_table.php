<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('banks');
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('business_id')->default('0');
            $table->string('bank_name');
            $table->string('branch');
            $table->string('account_title');
            $table->string('account_number');
            $table->string('iban');
            $table->string('swift_code');
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
        Schema::dropIfExists('banks');
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('business_id')->default(0);
            $table->string('bank_title');
            $table->string('country_code');
            $table->string('bank_code');
            $table->string('account_number');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
