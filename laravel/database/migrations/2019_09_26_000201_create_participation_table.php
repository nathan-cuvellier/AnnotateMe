<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participation', function (Blueprint $table) {
            $table->increments('id_part');
            $table->integer('id_prj');
            $table->integer('id_cptlvl');
            $table->integer('id_exp');
            $table->string('expert_project_confidence_level',20)->nullable();

            $table->foreign('id_prj')->references('id_prj')->on('project');
            $table->foreign('id_cptlvl')->references('id_cptlvl')->on('competence_level');
            $table->foreign('id_exp')->references('id_exp')->on('expert');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participation');
    }
}
