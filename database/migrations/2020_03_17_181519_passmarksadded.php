<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Passmarksadded extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('sm_exams', function (Blueprint $table) {
            $table->decimal('passmark',18,2);
        });
        Schema::table('sm_exam_setups', function (Blueprint $table) {
            $table->decimal('passmark',18,2);
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
