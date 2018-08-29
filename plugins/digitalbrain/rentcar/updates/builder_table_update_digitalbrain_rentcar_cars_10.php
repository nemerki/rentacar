<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarCars10 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->integer('brand_id')->nullable()->change();
            $table->integer('mdl_id')->nullable()->change();
            $table->integer('trim_id')->nullable()->change();
            $table->integer('color_id')->nullable()->change();
            $table->integer('ban_id')->nullable()->change();
            $table->integer('fuel_id')->nullable()->change();
            $table->integer('engine_volume_id')->nullable()->change();
            $table->integer('year_id')->nullable()->change();
            $table->integer('wheel_id')->nullable()->change();
            $table->integer('insurance_id')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->integer('seat_id')->nullable()->change();
            $table->integer('user_id')->nullable()->change();
            $table->string('slug', 191)->nullable()->change();
            $table->integer('transmision_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_cars', function($table)
        {
            $table->integer('brand_id')->nullable(false)->change();
            $table->integer('mdl_id')->nullable(false)->change();
            $table->integer('trim_id')->nullable(false)->change();
            $table->integer('color_id')->nullable(false)->change();
            $table->integer('ban_id')->nullable(false)->change();
            $table->integer('fuel_id')->nullable(false)->change();
            $table->integer('engine_volume_id')->nullable(false)->change();
            $table->integer('year_id')->nullable(false)->change();
            $table->integer('wheel_id')->nullable(false)->change();
            $table->integer('insurance_id')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->integer('seat_id')->nullable(false)->change();
            $table->integer('user_id')->nullable(false)->change();
            $table->string('slug', 191)->nullable(false)->change();
            $table->integer('transmision_id')->nullable(false)->change();
        });
    }
}
