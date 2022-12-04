<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentMarkListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_mark_list', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('term')->comment(' 1 => 1st Term, 2 => 2nd Term, 3 => 3rd Term');
            $table->string('maths');
            $table->string('science');
            $table->string('history');
            $table->unsignedBigInteger('students_id');
            $table->foreign('students_id')
              ->references('id')->on('students')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('student_mark_list');
    }
}
