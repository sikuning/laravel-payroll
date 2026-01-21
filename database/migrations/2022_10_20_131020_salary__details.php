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
        Schema::create('salary_details', function (Blueprint $table) {
            $table->id();
            $table->integer('employee');
            $table->string('month');
            $table->integer('basic_salary')->nullable();
            $table->integer('total_allowance')->nullable();
            $table->integer('total_deduction')->nullable();
            $table->integer('total_late')->nullable();
            $table->integer('total_late_amount')->nullable();
            $table->integer('total_absence')->nullable();
            $table->integer('total_absence_amount')->nullable();
            $table->integer('hourly_rate')->nullable();
            $table->integer('total_present')->nullable();
            $table->integer('total_leave')->nullable();
            $table->integer('total_working_days')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('gross_salary')->nullable();
            $table->integer('taxable_salary')->nullable();
            $table->integer('net_salary')->nullable();
            $table->integer('working_hour')->nullable();
            $table->tinyInteger('status')->default('0');
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
        Schema::dropIfExists('bonuses');
    }
};
