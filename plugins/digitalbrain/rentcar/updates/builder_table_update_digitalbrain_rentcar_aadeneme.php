<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarAadeneme extends Migration
{
    public function up()
    {
        Schema::rename('digitalbrain_rentcar_deneme', 'digitalbrain_rentcar_aadeneme');
        Schema::table('digitalbrain_rentcar_aadeneme', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::rename('digitalbrain_rentcar_aadeneme', 'digitalbrain_rentcar_deneme');
        Schema::table('digitalbrain_rentcar_deneme', function($table)
        {
            $table->increments('id')->unsigned()->change();
        });
    }
}
