<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarRentals4 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_rentals', function($table)
        {
            $table->integer('user_id')->unsigned()->change();
            $table->integer('car_id')->unsigned()->change();
            $table->dateTime('start_date')->nullable()->unsigned(false)->default(null)->change();
            $table->dateTime('end_date')->nullable()->unsigned(false)->default(null)->change();
            $table->string('name')->change();
            $table->string('phone')->change();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_rentals', function($table)
        {
            $table->integer('user_id')->unsigned(false)->change();
            $table->integer('car_id')->unsigned(false)->change();
            $table->date('start_date')->nullable()->unsigned(false)->default(null)->change();
            $table->date('end_date')->nullable()->unsigned(false)->default(null)->change();
            $table->string('name', 191)->change();
            $table->string('phone', 191)->change();
        });
    }
}
