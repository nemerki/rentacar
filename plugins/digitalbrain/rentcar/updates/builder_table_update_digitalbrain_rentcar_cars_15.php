<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarCars15 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->text('rejected_comment')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->dropColumn('rejected_comment');
        });
    }
}
