<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('business_id')->default(0);
            $table->string('name');
            $table->string('title');
            $table->string('slug');
            $table->text('meta_discription')->nullable();
            $table->string('heading')->nullable();
            $table->text('content')->nullable();
            $table->tinyInteger('is_active')->default(1)->comment('1=Active,2=InActive');
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
        Schema::dropIfExists('pages');
    }
}
