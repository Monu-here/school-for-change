<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmBillIssueItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_bill_issue_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->decimal('amount',18,2)->nullable();
            $table->decimal('qty',18,2)->nullable();
            $table->decimal('discount',18,2)->nullable();
            $table->tinyInteger('isdiscountpercentage')->default(0);
            $table->decimal('total',18,2)->nullable();
            $table->integer('sync')->nullable();
            $table->integer('bill_id')->unsigned();
            $table->foreign('bill_id')->references('id')->on('sm_bill_issues')->onDelete('cascade');
            $table->integer('fee_id')->unsigned();
            $table->foreign('fee_id')->references('id')->on('sm_fees_classes')->onDelete('cascade');
            $table->decimal('paid',18,2)->nullable();
            $table->decimal('pay',18,2)->nullable();
            $table->decimal('taxable')->nullable();
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
        Schema::dropIfExists('sm_bill_issue_items');
    }
}
