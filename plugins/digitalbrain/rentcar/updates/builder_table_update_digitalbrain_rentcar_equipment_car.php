<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarEquipmentCar extends Migration
{
    public function up()
    {
        Schema::rename('digitalbrain_rentcar_car_equipments', 'digitalbrain_rentcar_equipment_car');
    }
    
    public function down()
    {
        Schema::rename('digitalbrain_rentcar_equipment_car', 'digitalbrain_rentcar_car_equipments');
    }
}
