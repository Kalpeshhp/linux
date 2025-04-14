<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorProductAttributeSelectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_product_attribute_selections', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('vendor_id');
            $table->unsignedSmallInteger('vendor_product_id');
            $table->unsignedSmallInteger('element_id');
            $table->unsignedSmallInteger('style_id');
            $table->unsignedSmallInteger('attribute_id');
            $table->string('style_name', 100)->nullable();
            $table->string('parent_style_name', 100)->nullable();
            $table->decimal('price', 8, 0)->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('sort_order')->default(1);
            $table->tinyInteger('parent_sort_order')->default(1);
            $table->text('child_thumb_image')->nullable();
            $table->text('parent_thumb_image')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps(0);

            $table->foreign('vendor_id')->references('vendor_id')->on('vendors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('vendor_product_id')->references('vendor_products_id')->on('vendor_products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('element_id')->references('id')->on('tailori_product_elements')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('style_id')->references('id')->on('tailori_product_element_styles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('attribute_id')->references('id')->on('tailori_product_element_style_attributes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_product_attribute_selections');
    }
}
