<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDigitalbrainRentcarTransferValues extends Migration
{
    public function up()
    {
        Schema::create('digitalbrain_rentcar_transfer_values', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('car_id')->unsigned();
            $table->decimal('city', 10, 0)->nullable();
            $table->decimal('airport', 10, 0)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('digitalbrain_rentcar_transfer_values');
    }
}
