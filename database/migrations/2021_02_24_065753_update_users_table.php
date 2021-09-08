<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table){
           $table->string('username')->unique()->after('name');
           $table->tinyInteger('is_active')->nullable()->after('remember_token');
           $table->tinyInteger('is_business')->nullable()->after('password');
           $table->bigInteger('business_id')->nullable()->after('is_business');
           $table->bigInteger('location_id')->nullable()->after('business_id');
           $table->integer('user_type_id')->nullable()->after('password');
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
        Schema::table('users', function (Blueprint $table){
            $table->dropColumn(['username', 'is_active', 'is_business', 'business_id', 'location_id', 'user_type_id']);
            $table->dropSoftDeletes();
        });
    }
}
