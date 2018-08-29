<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarCars3 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->integer('transmision_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->dropColumn('transmision_id');
        });
    }
}
