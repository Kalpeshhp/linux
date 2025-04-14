<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTailoriProductElementStyleAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tailori_product_element_style_attributes', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('style_id');
            $table->string('tailori_attribute_code', 191);
            $table->string('attribute_name', 191);
            $table->text('image')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps(0);
            $table->foreign('style_id')->references('id')->on('tailori_product_element_styles')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tailori_product_element_style_attributes');
    }
}
