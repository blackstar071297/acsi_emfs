<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCanceledByToEmployeeMovementFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_movement_forms', function (Blueprint $table) {
            //
            $table->string('canceled_by')->nullable();
            $table->foreign('canceled_by')->references('empno')->on('emp_info');
            $table->date('date_canceled')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_movement_forms', function (Blueprint $table) {
            //
        });
    }
}
