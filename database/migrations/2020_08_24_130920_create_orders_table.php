<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('order_id')->default('0');
            $table->string('customername');
            $table->string('customer_address');
            $table->string('phone_number');
            $table->integer('qty');
            $table->string('tax')->nullable();
            $table->string('discountvalue')->nullable();
            $table->double('subtotal');
            $table->double('total');
            $table->double('advance_payment')->nullable();
            $table->double('due_payment')->nullable();
            $table->date('due_date');
            $table->integer('user_id');
            $table->string('pickup_address');
            $table->string('pickup_time');
            $table->string('delivery_address');
            $table->integer('orderstatus_id')->unsigned()->default('1');
            $table->foreign('orderstatus_id')->references('id')->on('orderstatuses')->onDelete('cascade');
            $table->integer('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
