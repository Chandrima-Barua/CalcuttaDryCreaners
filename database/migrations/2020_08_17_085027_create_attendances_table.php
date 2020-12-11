<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('date');
            $table->enum('status',array('absent','present'));
            $table->time('start_time');
            $table->time('end_time');
            // $table->string('leaveType',100)->nullable();
            // $table->string('halfDayType',100)->nullable();

      		// $table->text('reason');
            // $table->enum('application_status',array('approved','rejected','pending'))->nullable();
            // $table->date('applied_on')->nullable();
			// $table->string('updated_by',100)->nullable();

            // $table->index('leaveType');
            // $table->foreign('leaveType')
            //     ->references('leaveType')->on('leavetypes')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');

			// $table->index('updated_by');
			// $table->foreign('updated_by')
			//       ->references('email')->on('admins')
			//       ->onUpdate('cascade')
			//       ->onDelete('cascade');

			// $table->index('halfDayType');
			// $table->foreign('halfDayType')
			// 	->references('leaveType')->on('leavetypes')
			// 	->onUpdate('cascade')
			// 	->onDelete('cascade');

            $table->unique(['user_id','date']);


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
        Schema::dropIfExists('attendances');
    }
}