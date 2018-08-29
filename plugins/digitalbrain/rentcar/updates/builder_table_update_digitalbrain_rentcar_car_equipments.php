<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarCarEquipments extends Migration
{
    public function up()
    {
        Schema::rename('digitalbrain_rentcar_equipment_car', 'digitalbrain_rentcar_car_equipments');
    }
    
    public function down()
    {
        Schema::rename('digitalbrain_rentcar_car_equipments', 'digitalbrain_rentcar_equipment_car');
    }
}
