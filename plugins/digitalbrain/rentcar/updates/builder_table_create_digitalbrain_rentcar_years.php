<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDigitalbrainRentcarYears extends Migration
{
    public function up()
    {
        Schema::create('digitalbrain_rentcar_years', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('year');
            $table->boolean('is_active');
            $table->integer('sort_order')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('digitalbrain_rentcar_years');
    }
}
