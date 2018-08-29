<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDigitalbrainRentcarSeats extends Migration
{
    public function up()
    {
        Schema::create('digitalbrain_rentcar_seats', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('number');
            $table->boolean('is_active')->default(1);
            $table->integer('sort_order')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('digitalbrain_rentcar_seats');
    }
}
