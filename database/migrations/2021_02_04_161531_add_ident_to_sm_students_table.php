<?php

use Doctrine\DBAL\Types\{StringType, Type};
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\{DB, Log};


class AddIdentToSmStudentsTable extends Migration
{

    public function __construct()
    {
        if (! Type::hasType('enum')) {
            Type::addType('enum', StringType::class);
        }
        // For point types
        //DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('point', 'string');
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_subjects', function (Blueprint $table) {
            //
            $table->string('identifier',100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_subjects', function (Blueprint $table) {
            $table->integer('identifier')->nullable()->change();
            
        });
    }
}
