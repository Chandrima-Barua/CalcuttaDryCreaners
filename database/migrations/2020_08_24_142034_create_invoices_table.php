<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_no');
            $table->string('order_no');
            $table->string('customername');
            $table->string('customer_address');
            $table->integer('qty');
            $table->string('discount')->nullable();;
            $table->string('tax')->nullable();
            $table->integer('amount');
            $table->integer('subtotal');
            $table->integer('total');
            $table->integer('amount_due');
            $table->date('due_date');
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
        Schema::dropIfExists('invoices');
    }
}
