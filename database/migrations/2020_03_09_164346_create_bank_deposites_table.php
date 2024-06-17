<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankDepositesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_deposites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_name');
            $table->string('acount_no');
            $table->date('date');
            $table->string('voucher_no');
            $table->boolean('is_varify');
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
        Schema::dropIfExists('bank_deposites');
    }
}
