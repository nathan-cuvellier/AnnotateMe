<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfidenceIntervalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('confidence_interval', function (Blueprint $table) {

            $table->increments('id_confidence_interval');
            $table->string('label_confidence_interval',20);
        });

        DB::statement("INSERT INTO public.confidence_interval VALUES (0,'Doubt'); ");
        DB::statement("INSERT INTO public.confidence_interval VALUES (1,'Confident'); ");
        DB::statement("INSERT INTO public.confidence_interval VALUES (2,'Highly confident'); ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('confidence_interval');
    }
}
