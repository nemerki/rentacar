<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarCars4 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->integer('rental_value_id')->unsigned();
            $table->integer('transfer_value_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->dropColumn('rental_value_id');
            $table->dropColumn('transfer_value_id');
        });
    }
}
