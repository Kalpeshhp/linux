<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTailoriProductElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tailori_product_elements', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('product_id'); 
            $table->string('tailori_element_code', 191); 
            $table->string('element_name', 191);
            $table->text('image_url')->nullable(); 
            $table->tinyInteger('sort_order')->default(1); 
            $table->tinyInteger('is_active')->default(1);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps(0);

            $table->foreign('product_id')->references('tailori_products_id')->on('tailori_products')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tailori_product_elements');
    }
}
