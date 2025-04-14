<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTailoriProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tailori_products', function (Blueprint $table) {
            $table->smallIncrements('tailori_products_id'); 
            $table->string('tailori_product_code', 191);
            $table->string('product_name', 191); 
            $table->tinyInteger('is_active')->default(1); 
            $table->timestamp('deleted_at')->nullable(); 
            $table->timestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tailori_products');
    }
}
