<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('emp_id');
            $table->string('emp_img')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('username');
            $table->string('department');
            $table->string('designation');
            $table->string('monthly_pay')->nullable();
            $table->string('hourly_pay')->nullable();
            $table->string('work_shift');
            $table->string('dob');
            $table->string('gender');
            $table->string('religion')->nullable();
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('emergenecy_contact')->nullbale();
            $table->string('date_of_joining');
            $table->string('date_of_leaving')->nullable();
            $table->string('email');
            $table->text('password');
            $table->tinyInteger('marital_status')->default('0');
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('employees');
    }
};
