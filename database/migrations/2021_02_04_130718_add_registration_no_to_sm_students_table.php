<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRegistrationNoToSmStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_students', function (Blueprint $table) {
            $table->string('regno',100)->nullable();
            $table->string('roll_no',100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_students', function (Blueprint $table) {
            $table->integer('roll_no')->nullable()->change();
            $table->dropColumn('regno');
        });
    }
}
