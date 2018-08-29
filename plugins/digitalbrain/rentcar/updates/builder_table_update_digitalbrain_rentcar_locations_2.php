<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarLocations2 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_locations', function($table)
        {
            $table->integer('car_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_locations', function($table)
        {
            $table->dropColumn('car_id');
        });
    }
}
