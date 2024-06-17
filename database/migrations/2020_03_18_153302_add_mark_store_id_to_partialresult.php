<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMarkStoreIdToPartialresult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_partial_result_stores', function (Blueprint $table) {
            $table->integer('mark_store_id')->unsigned();
            $table->foreign('mark_store_id')->references('id')->on('sm_mark_stores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partialresult', function (Blueprint $table) {
            //
        });
    }
}
