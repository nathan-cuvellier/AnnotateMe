<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterfaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interface', function (Blueprint $table) {
            
            $table->increments('id_int');
            $table->string('label_int',50);
        });

        DB::statement("INSERT INTO public.interface VALUES (1,'Classification'); ");
        DB::statement("INSERT INTO public.interface VALUES (2,'Pairwise similarity'); ");
        DB::statement("INSERT INTO public.interface VALUES (3,'Triplewise similarity'); ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interface');
    }
}
