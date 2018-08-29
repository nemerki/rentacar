<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDigitalbrainRentcarLocations extends Migration
{
    public function up()
    {
        Schema::create('digitalbrain_rentcar_locations', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('city')->nullable();
            $table->string('street_address')->nullable();
            $table->decimal('lat', 10, 6)->nullable();
            $table->decimal('lan', 10, 6)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('digitalbrain_rentcar_locations');
    }
}
