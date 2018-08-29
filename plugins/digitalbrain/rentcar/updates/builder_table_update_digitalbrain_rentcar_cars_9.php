<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarCars9 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->boolean('is_active')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->dropColumn('is_active');
        });
    }
}
