<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarRentals6 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_rentals', function($table)
        {
            $table->string('confirm')->default('0');
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_rentals', function($table)
        {
            $table->dropColumn('confirm');
        });
    }
}
