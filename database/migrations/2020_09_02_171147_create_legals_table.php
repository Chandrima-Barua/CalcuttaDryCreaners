<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legals', function (Blueprint $table) {
            $table->increments('id');
            $table->date('bike_starting')->nullable();
            $table->date('bike_ending')->nullable();
            $table->date('insurance_starting');
            $table->date('insurance_ending');
            $table->date('taxtoken_starting');
            $table->date('taxtoken_ending');
            $table->date('fitness_starting')->nullable();
            $table->date('fitness_ending')->nullable();
            $table->integer('legal_categories_id')->unsigned();
            $table->foreign('legal_categories_id')->references('id')->on('legal_categories')->onDelete('cascade');
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
        Schema::dropIfExists('legals');
    }
}
