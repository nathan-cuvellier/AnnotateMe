<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionModeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_mode', function (Blueprint $table) {

            $table->increments('id_mode');
            $table->string('label_mode',50);
        });

        DB::statement("INSERT INTO public.session_mode VALUES (1,'Timer'); ");
        DB::statement("INSERT INTO public.session_mode VALUES (2,'Number of annotations'); ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_mode');
    }
}
