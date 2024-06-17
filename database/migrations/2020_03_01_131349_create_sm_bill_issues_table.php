<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmBillIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_bill_issues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->date('date')->nullable();
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('sm_students')->onDelete('cascade');
            $table->decimal('paid',18,2)->nullable();
            $table->decimal('due',18,2)->nullable();
            $table->decimal('total',18,2)->nullable();
            $table->integer('academicyear_id')->unsigned();
            $table->foreign('academicyear_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
            $table->text('credit_bill_no')->nullable();
            $table->decimal('previousdue',18,2)->nullable();
            $table->decimal('taxable',18,2)->nullable();
            $table->decimal('taxamount',18,2)->nullable();
            $table->decimal('amount',18,2)->nullable();
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
        Schema::dropIfExists('sm_bill_issues');
    }
}
