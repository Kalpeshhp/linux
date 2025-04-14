<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTailoriProductElementStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tailori_product_element_styles', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('element_id');
            $table->string('style_name', 191);
            $table->string('tailori_style_code', 191);
            $table->tinyInteger('is_active')->default(1);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps(0);
            $table->foreign('element_id')->references('id')->on('tailori_product_elements')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tailori_product_element_styles');
    }
}
