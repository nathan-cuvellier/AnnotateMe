<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNullToExpert extends Migration
{
    /**
     * Run the migrations.
     * 
     * Set nullable column in order to respect the RGPD when user want delete his account
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expert', function (Blueprint $table) {
            $table->string('name_exp', 50)->nullable()->change();
            $table->string('firstname_exp', 50)->nullable()->change();
            $table->date('bd_date_exp')->nullable()->change();
            $table->string('sex_exp', 50)->nullable()->change();
            $table->string('address_exp', 50)->nullable()->change();
            $table->string('pc_exp', 10)->nullable()->change();
            $table->string('mail_exp',50)->nullable()->change();
            $table->string('tel_exp',50)->nullable()->change();
            $table->string('city_exp',50)->nullable()->change();
            $table->string('pwd_exp',100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expert', function (Blueprint $table) {
            //
        });
    }
}
