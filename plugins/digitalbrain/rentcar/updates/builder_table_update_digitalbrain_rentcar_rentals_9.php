<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarRentals9 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_rentals', function($table)
        {
            $table->string('rent_method')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_rentals', function($table)
        {
            $table->dropColumn('rent_method');
        });
    }
}
