<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->timestamp('deadline')->nullable();
            $table->string('name')->nullable();
            $table->integer('status')->nullable();
            $table->unsignedInteger('subject_id')->nullable();
            $table->string('course')->nullable();
            $table->text('description')->nullable();
            $table->float('price')->nullable();
            $table->unsignedInteger('student_id')->nullable();
            $table->unsignedInteger('teacher_id')->nullable();

            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects');

            $table->foreign('student_id')
                ->references('id')
                ->on('students_info')
                ->onDelete('restrict');

            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers_info')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
