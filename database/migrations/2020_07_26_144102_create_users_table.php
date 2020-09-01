<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('surname')->nullable();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('city')->nullable();
            $table->unsignedInteger('picture')->nullable();
            $table->string('password')->nullable();
            $table->string('api_token')->nullable();
            $table->json('settings')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->softDeletes();

            $table->foreign('picture')
                ->references('id')
                ->on('files')
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
        Schema::dropIfExists('users');
    }
}
