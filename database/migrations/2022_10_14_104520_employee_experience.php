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
        Schema::create('employee_experience', function (Blueprint $table) {
            $table->id('id');
            $table->string('employee');
            $table->string('organisation');
            $table->string('designation');
            $table->string('from_date');
            $table->string('to_date');
            $table->string('responsibility');
            $table->string('skills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_experience');
    }
};
