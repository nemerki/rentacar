<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDigitalbrainRentcarRentalValues extends Migration
{
    public function up()
    {
        Schema::create('digitalbrain_rentcar_rental_values', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('car_id')->unsigned();
            $table->decimal('one_day', 10, 0);
            $table->decimal('three_day', 10, 0);
            $table->decimal('seven_day', 10, 0);
            $table->decimal('thirty_day', 10, 0);
            $table->decimal('over_thirty_day', 10, 0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('digitalbrain_rentcar_rental_values');
    }
}
