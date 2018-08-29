<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarTrims2 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_trims', function($table)
        {
            $table->integer('brand_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_trims', function($table)
        {
            $table->dropColumn('brand_id');
        });
    }
}
