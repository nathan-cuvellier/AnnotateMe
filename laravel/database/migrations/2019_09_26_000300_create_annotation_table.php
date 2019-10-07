<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('annotation', function (Blueprint $table) {
           
            $table->increments('id_annot');
            $table->integer('id_exp');
            $table->integer('id_cat');
            $table->integer('id_data');
            $table->date('date');
            $table->integer('expert_sample_confidence_level')->nullable();

            $table->foreign('id_exp')->references('id_exp')->on('expert');
            $table->foreign('id_cat')->references('id_cat')->on('category');
            $table->foreign('id_data')->references('id_data')->on('data');
            $table->foreign('date')->references('date')->on('date');
            $table->foreign('expert_sample_confidence_level')->references('id_confidence_interval')->on('confidence_interval');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('annotation');
    }
}
