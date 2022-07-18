<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeMovementFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_movement_forms', function (Blueprint $table) {
            $table->string('request_no')->primary();
            $table->string('emp_no');
            $table->foreign('emp_no')->references('empno')->on('emp_info');
            $table->string('request_by');
            $table->foreign('request_by')->references('empno')->on('emp_info');

            $table->string('from_position')->nullable();
            $table->string('from_job_status')->nullable();
            $table->string('from_job_level')->nullable();
            $table->string('from_role')->nullable();
            $table->string('from_department')->nullalbe();
            $table->string('from_cost_center')->nullable();
            $table->float('from_salary')->nullable();
            $table->float('from_allowance')->nullable();
            $table->string('from_immediate_superior')->nullable();
            $table->foreign('from_immediate_superior')->references('empno')->on('emp_info');
            $table->string('from_manager')->nullable();
            $table->foreign('from_manager')->references('empno')->on('emp_info');
            $table->string('from_contract')->nullable();
            $table->string('from_others')->nullable();

            $table->boolean('move_position')->default(0);
            $table->boolean('move_job_status')->default(0);
            $table->boolean('move_job_level')->default(0);
            $table->boolean('move_role')->default(0);
            $table->boolean('move_department')->default(0);
            $table->boolean('move_cost_center')->default(0);
            $table->boolean('move_salary')->default(0);
            $table->boolean('move_allowance')->default(0);
            $table->boolean('move_immediate_superior')->default(0);
            $table->boolean('move_manager')->default(0);
            $table->boolean('move_contract')->default(0);
            $table->boolean('move_others')->default(0);

            $table->string('to_position')->nullable();
            $table->string('to_job_status')->nullable();
            $table->string('to_job_level')->nullable();
            $table->string('to_role')->nullable();
            $table->string('to_department')->nullalbe();
            $table->string('to_cost_center')->nullable();
            $table->float('to_salary')->nullable();
            $table->float('to_allowance')->nullable();
            $table->string('to_immediate_superior')->nullable();
            $table->foreign('to_immediate_superior')->references('empno')->on('emp_info');
            $table->string('to_manager')->nullable();
            $table->foreign('to_manager')->references('empno')->on('emp_info');
            $table->string('to_contract')->nullable();
            $table->string('to_others')->nullable();

            $table->date('superior_accept_date')->nullable();
            $table->date('new_superior_accept_date')->nullable();
            $table->date('manager_accept_date')->nullable();
            $table->date('new_manager_accept_date')->nullable();
            $table->date('cable_head_accept_date')->nullable();
            $table->date('employee_accept_date')->nullable();
            $table->date('hr_accept_date')->nullable();
            $table->date('effectivity_date')->nullable();
            $table->string('reason_for_movement')->nullable();
            $table->boolean('is_closed')->default(0);
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
        Schema::dropIfExists('employee_movement_forms');
    }
}
