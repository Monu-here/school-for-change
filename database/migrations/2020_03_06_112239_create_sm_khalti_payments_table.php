<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmKhaltiPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_khalti_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idx');
            $table->string('token');
            $table->decimal('amount',18,2);
            $table->integer('bill_no');
            $table->integer('fiscalyear_id')->unsigned();
            $table->foreign('fiscalyear_id')->references('id')->on('sm_fiscal_years');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('sm_khalti_payments');
    }
}
