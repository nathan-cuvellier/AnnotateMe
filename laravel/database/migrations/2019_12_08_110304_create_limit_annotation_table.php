<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLimitAnnotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('limit_annotation', function (Blueprint $table) {
            $table->increments('id_limit_annotation')->index();
            $table->integer('id_exp');
            $table->integer('id_prj');
            $table->dateTime('date_limit_annotation');

            $table->foreign('id_exp')->references('id_exp')->on('expert');
            $table->foreign('id_prj')->references('id_prj')->on('project');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('limit_annotation');
    }
}
