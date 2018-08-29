<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarBrands extends Migration
{
    public function up()
    {
        Schema::rename('digitalbrain_rentcar_brand', 'digitalbrain_rentcar_brands');
        Schema::table('digitalbrain_rentcar_brands', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->string('name')->change();
        });
    }
    
    public function down()
    {
        Schema::rename('digitalbrain_rentcar_brands', 'digitalbrain_rentcar_brand');
        Schema::table('digitalbrain_rentcar_brand', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->string('name', 191)->change();
        });
    }
}
