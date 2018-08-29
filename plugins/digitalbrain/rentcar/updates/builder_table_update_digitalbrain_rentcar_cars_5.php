<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarCars5 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->dropColumn('location_id');
            $table->dropColumn('rental_value_id');
            $table->dropColumn('transfer_value_id');
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->integer('location_id')->unsigned();
            $table->integer('rental_value_id')->unsigned();
            $table->integer('transfer_value_id')->unsigned();
        });
    }
}
