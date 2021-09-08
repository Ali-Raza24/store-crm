<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPhoneNumberVerificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_phone_number_verification', function (Blueprint $table) {
            $table->id();
            $table->string('mobile_no');
            $table->string('otp');
            $table->tinyInteger('is_verified')->default(0);
            $table->tinyInteger('sent_count')->nullable();
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
        Schema::dropIfExists('user_phone_number_verification');
    }
}
