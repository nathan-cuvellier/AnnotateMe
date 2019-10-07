<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            
            $table->increments('id_data');
            $table->string('pathname_data',500);
            $table->decimal('priority_data', 5, 2)->default(0)->nullable();
            $table->integer('nbannotation_data')->nullable();
            $table->integer('id_prj');

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
        Schema::dropIfExists('data');
    }
}
