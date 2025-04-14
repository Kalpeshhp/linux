<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFabricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fabrics', function (Blueprint $table) {
            $table->smallIncrements('fabric_id'); 
            $table->string('vendor_key', 20)->nullable();
            $table->string('tailori_fabric_code', 191)->nullable();
            $table->string('fabric_name', 191)->nullable();
            $table->string('product_type', 191)->nullable();
            $table->string('brand', 191)->nullable();
            $table->string('wear_type', 191)->nullable(); 
            $table->string('color', 191)->nullable();
            $table->string('design_pattern', 191)->nullable(); 
            $table->string('fabric_blend', 191)->nullable();
            $table->mediumText('description')->nullable();
            $table->decimal('price', 8, 2)->default(0); 
            $table->smallInteger('sort_order')->nullable(); 
            $table->string('thumbnail_image', 191)->nullable();
            $table->string('bestfit_image', 191)->nullable(); 
            $table->string('original_image', 191)->nullable();
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
        Schema::dropIfExists('fabrics');
    }
}
