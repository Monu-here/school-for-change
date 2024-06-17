<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_pan');
            $table->string('customer_phone');
            $table->string('student_name');
            $table->bigInteger('student_rollno');
            $table->string('student_class');
            $table->string('student_regno');
            $table->string('fiscal_year');
            $table->string('billno');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_printed')->default(false);
            $table->boolean('is_syncedwithird')->default(false);
            $table->string('printed_by');
            $table->string('issuedby')->default(false);
            $table->integer('printed_copies')->default(0);
            $table->decimal('amount',18,2);
            $table->decimal('taxable',18,2);
            $table->decimal('tax',18,2);
            $table->decimal('total',18,2);
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('sm_students');
            $table->integer('fiscalyear_id')->unsigned();
            $table->foreign('fiscalyear_id')->references('id')->on('sm_fiscal_years');
            $table->date('date');
            
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
        Schema::dropIfExists('bills');
    }
}
