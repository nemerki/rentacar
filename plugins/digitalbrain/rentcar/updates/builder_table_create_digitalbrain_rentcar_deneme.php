<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDigitalbrainRentcarDeneme extends Migration
{
    public function up()
    {
        Schema::create('digitalbrain_rentcar_deneme', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('digitalbrain_rentcar_deneme');
    }
}
