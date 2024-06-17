<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmFeesClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_fees_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');
            $table->decimal('amount',18,2);
            $table->integer('class_id')->unsigned();
            $table->foreign('class_id')->references('id')->on('sm_classes')->onDelete('cascade');
            $table->tinyInteger('istaxable')->default(0);
            $table->tinyInteger('istransport')->default(0);
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
        Schema::dropIfExists('sm_fees_classes');
    }
}
