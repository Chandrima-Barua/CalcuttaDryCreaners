<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->string('service_id');
            $table->integer('item_id')->unsigned();
            $table->string('status');
            $table->string('packaging');
            $table->double('service_charge')->nullable();
            $table->integer('quantity');
            $table->double('price');
            $table->boolean('urgent')->default(false);
            $table->boolean('regular')->default(true);
            $table->date('date');
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
        Schema::dropIfExists('order_items');
    }
}
