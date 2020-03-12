<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfidentLevelToTriplewiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('triplewise', function (Blueprint $table) {
            $table->integer('expert_sample_confidence_level');

            $table->foreign('expert_sample_confidence_level')->references('id_confidence_interval')->on('confidence_interval');
            
            $table->dropColumn('id_cat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('triplewise', function (Blueprint $table) {
            //
        });
    }
}
