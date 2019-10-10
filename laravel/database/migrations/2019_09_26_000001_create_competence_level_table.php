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

        DB::statement("INSERT INTO public.competence_level VALUES (1,'Not an expert'); ");
        DB::statement("INSERT INTO public.competence_level VALUES (2,'Confident'); ");
        DB::statement("INSERT INTO public.competence_level VALUES (3,'Highly confident'); ");
        DB::statement("INSERT INTO public.competence_level VALUES (4,'Expert'); ");

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
