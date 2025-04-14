<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_brands', function (Blueprint $table) {
            $table->increments('id'); 
            $table->unsignedSmallInteger('vendor_id');
            $table->unsignedSmallInteger('brand_id');
            $table->tinyInteger('is_active')->unsigned()->default(1);
        
            $table->foreign('vendor_id')->references('vendor_id')->on('vendors')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('brand_id')->references('brand_id')->on('brands') ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_brands');
    }
}
