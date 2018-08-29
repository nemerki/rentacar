<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarLocations extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_locations', function($table)
        {
            $table->renameColumn('city', 'city_id');
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_locations', function($table)
        {
            $table->renameColumn('city_id', 'city');
        });
    }
}
