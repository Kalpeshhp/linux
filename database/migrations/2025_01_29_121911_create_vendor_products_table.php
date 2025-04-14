<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_products', function (Blueprint $table) {
            $table->smallIncrements('vendor_products_id');
            $table->unsignedSmallInteger('vendor_id');
            $table->unsignedSmallInteger('tailori_products_id');
            $table->integer('element_limit')->default(0);
            $table->integer('style_limit')->default(0);
            $table->integer('attribute_limit')->default(0);
            $table->integer('fabric_limit')->default(0);
            $table->tinyInteger('is_active')->unsigned();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps(0);

            $table->foreign('vendor_id')->references('vendor_id')->on('vendors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tailori_products_id')->references('tailori_products_id')->on('tailori_products')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_products');
    }
}
