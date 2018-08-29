<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDigitalbrainRentcarCarEquipments extends Migration
{
    public function up()
    {
        Schema::create('digitalbrain_rentcar_car_equipments', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('equipment_id')->unsigned();
            $table->integer('car_id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('digitalbrain_rentcar_car_equipments');
    }
}
