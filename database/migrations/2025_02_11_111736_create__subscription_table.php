<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription', function (Blueprint $table) {
            $table->smallIncrements('subscription_id')->unsigned();
            $table->smallInteger('vendor_id')->unsigned();
            $table -> Date('start_date');
            $table -> Date('end_date');
            $table->smallInteger('duration_in_months')->unsigned();
            $table->tinyInteger('islatest')->unsigned()->default(1);
            $table->tinyInteger('isactive')->unsigned()->default(1);
            $table ->smallInteger('version')->unsigned();
            $table->tinyInteger('is_trial')->unsigned()->default(0);
            $table->timestamps();
            $table->foreign('vendor_id')->references('vendor_id')->on('vendors')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription');
    }
}
