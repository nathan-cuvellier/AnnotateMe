<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('category', function (Blueprint $table) {

            $table->increments('id_cat');
            $table->string('label_cat',50);
            $table->integer('id_prj');
            $table->integer('num_line')->nullable();

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
        Schema::dropIfExists('category');
    }
}
