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
        Schema::create('monthly_pay_grade', function (Blueprint $table) {
            $table->id('monthly_id');
            $table->string('pay_grade');
            $table->integer('gross_salary');
            $table->string('percentage_of_basic');
            $table->integer('basic_salary');
            $table->integer('overtime_rate')->nullable();
            $table->string('allowance')->nullable();
            $table->string('deduction')->nullable();
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
        Schema::dropIfExists('monthly_pay_grade');
    }
};
