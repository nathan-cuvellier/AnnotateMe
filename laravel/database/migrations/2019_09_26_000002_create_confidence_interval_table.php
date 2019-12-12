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

        DB::table('confidence_interval')->insert([
            'label_confidence_interval' => 'Doubt',
        ]);
        DB::table('confidence_interval')->insert([
            'label_confidence_interval' => 'Confident',
        ]);
        DB::table('confidence_interval')->insert([
            'label_confidence_interval' => 'Highly confident',
        ]);
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
