<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('stripe_id');
            $table->string('stripe_monthly_id')->nullable()->after('yearly_price');
            $table->string('stripe_yearly_id')->nullable()->after('stripe_monthly_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->string('stripe_id')->nullable();
            $table->dropColumn(['stripe_monthly_id', 'stripe_yearly_id']);
        });
    }
}
