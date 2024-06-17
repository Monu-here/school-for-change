<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Addpaymnttobill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->integer('payment_type');
            $table->integer('payment_id')->nullable();             
         });
       
        Schema::create('temp_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->decimal('total',18,2);
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('sm_students');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
