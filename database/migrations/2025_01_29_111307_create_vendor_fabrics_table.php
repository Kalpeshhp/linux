<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorFabricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_fabrics', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->unsignedSmallInteger('vendor_id'); 
            $table->unsignedSmallInteger('fabric_id');
            $table->string('fabric_name', 200)->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 8, 0)->default(0);
            $table->tinyInteger('is_active')->unsigned()->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps(0);
            $table->smallInteger('sort_order')->nullable();

            $table->foreign('vendor_id')->references('vendor_id')->on('vendors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fabric_id')->references('fabric_id')->on('fabrics')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_fabrics');
    }
}
