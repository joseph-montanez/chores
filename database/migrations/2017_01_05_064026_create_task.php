<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id');
            $table->enum('distribution', ['random','round_robin'])->default('random');
            $table->string('name');
            $table->text('description');
            $table->integer('points')->default(0);
            $table->boolean('reoccurring')->default(false);
            $table->dateTime('start_at');
            $table->dateTime('end_at')->nullable()->default(null);
            $table->string('timezone');
            $table->integer('frequency')->default(0);
            $table->integer('interval')->default(0);
            $table->integer('count')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tasks');
    }
}
