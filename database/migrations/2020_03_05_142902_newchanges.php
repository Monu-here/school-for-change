<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Newchanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('sm_exam_types', function (Blueprint $table) {
            $table->unsignedInteger('session_id')->nullable();
            $table->foreign('session_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
              
        });

        Schema::table('sm_exam_setups', function (Blueprint $table) {
            $table->double('passmarks',8,2);
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
