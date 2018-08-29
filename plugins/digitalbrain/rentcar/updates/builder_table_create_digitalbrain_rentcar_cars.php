<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDigitalbrainRentcarCars extends Migration
{
    public function up()
    {
        Schema::create('digitalbrain_rentcar_cars', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('brand_id')->unsigned();
            $table->integer('model_id')->unsigned();
            $table->integer('trim_id')->unsigned();
            $table->integer('color_id')->unsigned();
            $table->integer('ban_id')->unsigned();
            $table->integer('fuel_id')->unsigned();
            $table->integer('engine_position_id')->nullable()->unsigned();
            $table->integer('engine_volume_id')->unsigned();
            $table->integer('year_id')->unsigned();
            $table->integer('wheel_id')->unsigned();
            $table->integer('insurance_id')->unsigned();
            $table->text('description');
            $table->text('other_equipment')->nullable();
            $table->integer('seat_id')->unsigned();
            $table->boolean('is_vip')->default(0);
            $table->boolean('is_rent')->default(0);
            $table->boolean('is_transfer')->default(0);
            $table->integer('location_id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('digitalbrain_rentcar_cars');
    }
}
