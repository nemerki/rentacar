<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteDigitalbrainRentcarAadeneme extends Migration
{
    public function up()
    {
        Schema::dropIfExists('digitalbrain_rentcar_aadeneme');
    }
    
    public function down()
    {
        Schema::create('digitalbrain_rentcar_aadeneme', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
        });
    }
}
