<?php

use App\Constants\IStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_companies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('contact_person');
            $table->string('contact_email')->unique();
            $table->string('contact_phone')->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('is_active')->default(IStatus::ACTIVE);
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
        Schema::dropIfExists('delivery_companies');
    }
}
