<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldToSmSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_subjects', function (Blueprint $table) {
            $table->decimal('grade_point',4,1)->nullable();
            $table->decimal('credit_hour',4,1)->nullable();
            $table->integer('identifier')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_subjects', function (Blueprint $table) {
            $table->dropColumn('grade_point');
            $table->dropColumn('credit_hour');
            $table->dropColumn('identifier');
        });
    }
}
