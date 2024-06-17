<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmScholarshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_scholarships', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->decimal('amount',10,2)->default(0);
            $table->integer('percentage')->default(0);
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('sm_students')->onDelete('cascade');
            $table->integer('fee_id')->unsigned();
            $table->foreign('fee_id')->references('id')->on('sm_fees_classes')->onDelete('cascade');
            $table->integer('class_id')->unsigned();
            $table->foreign('class_id')->references('id')->on('sm_classes')->onDelete('cascade');
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
        Schema::dropIfExists('sm_scholarships');
    }
}
