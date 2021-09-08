<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSameAddressToOrderAddressesTable extends Migration
{
    public function up()
    {
        Schema::table('order_addresses', function (Blueprint $table) {
            $table->tinyInteger('same_address')->nullable()->after('type');
        });
    }

    public function down()
    {
        Schema::table('order_addresses', function (Blueprint $table) {
            $table->dropColumn('same_address');
        });
    }
}
