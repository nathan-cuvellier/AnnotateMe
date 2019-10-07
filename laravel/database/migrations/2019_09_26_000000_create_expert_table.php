<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expert', function (Blueprint $table) {
            
            $table->increments('id_exp');

            $table->string('name_exp', 50);
            $table->string('firstname_exp', 50);
            $table->date('bd_date_exp');
            $table->string('sex_exp', 50);
            $table->string('address_exp', 50);
            $table->integer('pc_exp');
            $table->string('mail_exp',50)->unique();
            $table->string('tel_exp',50)->unique();
            $table->string('city_exp',50);
            $table->string('pwd_exp',100);
            $table->string('type_exp',20);
        });
       
        DB::statement("ALTER TABLE expert ADD CONSTRAINT check_expert_typeexp CHECK (type_exp IN ('expert', 'admin',  'superadmin'))");
        DB::statement("INSERT INTO public.expert VALUES (1,'Admin','super',now(),'null','null',0,'coucou@gmail.com','null','null','\$2y\$10\$E1cdLO7ZLDFqS9Bs3sCEC.IWWQsIxRUOKQnOLvGHFJg2.rlidxp1K','superadmin'); ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expert');
    }
}
