<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsoptionalToSmResultStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_result_stores', function (Blueprint $table) {
            //
            $table->tinyInteger('isop')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_result_stores', function (Blueprint $table) {
            //
            $table->dropColumn('isop');

        });
    }
}
