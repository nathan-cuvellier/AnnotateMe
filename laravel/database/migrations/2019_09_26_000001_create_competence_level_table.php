<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetenceLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('competence_level', function (Blueprint $table) {

            $table->increments('id_cptlvl');
            $table->string('label_cptlvl',50);
        });

        DB::table('competence_level')->insert([
            'label_cptlvl' => 'Not an expert',
        ]);
        DB::table('competence_level')->insert([
            'label_cptlvl' => 'Confident',
        ]);
        DB::table('competence_level')->insert([
            'label_cptlvl' => 'Highly confident',
        ]);
        DB::table('competence_level')->insert([
            'label_cptlvl' => 'Expert',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competence_level');
    }
}
