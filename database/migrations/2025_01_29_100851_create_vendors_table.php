<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->smallIncrements('vendor_id');
            $table->string('user_uid', 191)->nullable();
            $table->string('username', 80)->nullable();
            $table->string('store_name', 191)->nullable();
            $table->mediumText('store_url')->nullable();
            $table->string('contact_number', 191)->nullable();
            $table->mediumText('address')->nullable();
            $table->string('city', 191)->nullable();
            $table->string('state', 191)->nullable();
            $table->string('pincode', 191)->nullable();
            $table->smallInteger('fabric_upload_limit')->unsigned();
            $table->string('plugin_ui', 15)->nullable();
            $table->string('store_ui', 15)->nullable();
            $table->tinyInteger('status')->unsigned();
            $table->tinyInteger('isSuperAdmin')->unsigned()->default(2);
            $table->timestamps(0);
        });

        Schema::create('users', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 191);
            $table->string('email', 191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 191);
            $table->string('remember_token', 100)->nullable();
            $table->timestamps(0); 
            $table->tinyInteger('status')->unsigned()->default(1); 
            $table->tinyInteger('user_group')->unsigned()->default(2); 
            $table->smallInteger('vendor_id')->unsigned();

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
        Schema::dropIfExists('users');
        Schema::dropIfExists('vendors');
    }
}
