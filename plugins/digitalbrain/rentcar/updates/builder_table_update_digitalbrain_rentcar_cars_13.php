<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarCars13 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->string('view')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->dropColumn('view');
        });
    }
}
