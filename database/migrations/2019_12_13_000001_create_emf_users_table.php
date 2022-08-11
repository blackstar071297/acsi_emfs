<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmfUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emf_users', function (Blueprint $table) {
            $table->increments('userid');
            $table->integer('useruniq')->unsigned()->index();
            $table->foreign('useruniq')->references('empid')->on('emp_info');
            $table->string('username')->nullable();
            $table->string('userpass')->nullable();
            $table->string('useraccess')->nullable();
            $table->string('position')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('empno')->nullable();
            $table->foreign('empno')->references('empno')->on('emp_info');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('emf_users');
    }
}
