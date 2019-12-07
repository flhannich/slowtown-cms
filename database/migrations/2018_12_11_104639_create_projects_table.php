<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id');
            $table->integer('status');
            $table->unsignedInteger('weight');
            $table->unsignedInteger('type');
            $table->string('title');
            $table->text('description');
            $table->text('content');
            $table->text('booking');
            $table->string('image');
            $table->string('slug')->unique();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users'); //->onDelete('cascade') .. Delete all entries of user when user gets deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
