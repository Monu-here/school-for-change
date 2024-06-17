<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Partialresult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_partial_result_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->decimal('marks',18,2);
            $table->boolean('pass')->default(0);
            $table->decimal('percentage',3,2);
            $table->decimal('gpapoint',3,2);
            $table->string('gpagrade');
            $table->integer('result_store_id')->unsigned();
            $table->foreign('result_store_id')->references('id')->on('sm_result_stores');
            $table->timestamps();
        });

        Schema::table('sm_result_stores', function (Blueprint $table) {
           $table->boolean('pass')->default(0);
           $table->decimal('percentage',3,2);
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
