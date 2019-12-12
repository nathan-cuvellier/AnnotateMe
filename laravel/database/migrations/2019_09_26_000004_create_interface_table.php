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

        DB::table('interface')->insert([
            'label_int' => 'Classification',
        ]);
        DB::table('interface')->insert([
            'label_int' => 'Pairwise similarity',
        ]);
        DB::table('interface')->insert([
            'label_int' => 'Triplewise similarity',
        ]);
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
