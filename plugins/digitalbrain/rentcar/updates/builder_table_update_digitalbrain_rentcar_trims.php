<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarTrims extends Migration
{
    public function up()
    {
        Schema::rename('digitalbrain_rentcar_trim', 'digitalbrain_rentcar_trims');
        Schema::table('digitalbrain_rentcar_trims', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->string('name')->change();
        });
    }
    
    public function down()
    {
        Schema::rename('digitalbrain_rentcar_trims', 'digitalbrain_rentcar_trim');
        Schema::table('digitalbrain_rentcar_trim', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->string('name', 191)->change();
        });
    }
}
