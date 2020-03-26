<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePairwiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pairwise', function (Blueprint $table) {
            $table->increments('id_pair');
            $table->integer('id_exp');
            $table->integer('id_data1');
            $table->integer('id_data2');
            $table->dateTime('date')->nullable();
            $table->integer('id_cat')->nullable();

            $table->foreign('id_exp')->references('id_exp')->on('expert');
            $table->foreign('id_data1')->references('id_data')->on('data');
            $table->foreign('id_data2')->references('id_data')->on('data');
            $table->foreign('id_cat')->references('id_cat')->on('category');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pairwise');
    }
}
