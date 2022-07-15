<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movement_records', function (Blueprint $table) {
            $table->increments('movement_record_id');
            $table->string('request_no');
            $table->foreign('request_no')->references('request_no')->on('employee_movement_forms');
            $table->integer('status_id');
            $table->foreign('status_id')->references('status_id')->on('statuses');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('movement_records');
    }
}
