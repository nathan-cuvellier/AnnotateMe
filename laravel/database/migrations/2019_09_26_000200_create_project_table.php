<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {

            $table->increments('id_prj');
            $table->string('name_prj',50)->unique();
            $table->string('desc_prj',500)->nullable();
            $table->integer('id_mode');
            $table->integer('id_int');
            $table->integer('id_exp');
            $table->decimal('value_mode')->nullable();
            $table->decimal('limit_prj',4,0)->nullable();

            $table->foreign('id_exp')->references('id_exp')->on('expert');
            $table->foreign('id_int')->references('id_int')->on('interface');
            $table->foreign('id_mode')->references('id_mode')->on('session_mode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project');
    }
}
