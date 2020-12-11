<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('itemTypeid')->nullable();
            $table->integer('typeid')->nullable();
            $table->string('name');
            $table->string('code');
            $table->integer('service_id');
            $table->string('slug');
            $table->boolean('discount');
            $table->integer('regularPrice');
            $table->integer('urgentPrice');
            $table->string('itemNote')->nullable();
            $table->integer('regularDeliveryTime');
            $table->integer('urgentDeliveryTime');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
