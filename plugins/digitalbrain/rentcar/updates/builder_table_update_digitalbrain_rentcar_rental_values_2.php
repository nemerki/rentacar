<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarRentalValues2 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_rental_values', function($table)
        {
            $table->decimal('one_day_region', 10, 0)->nullable();
            $table->decimal('three_day_region', 10, 0)->nullable();
            $table->decimal('seven_day_region', 10, 0)->nullable();
            $table->decimal('thirty_day_region', 10, 0)->nullable();
            $table->decimal('over_thirty_day_region', 10, 0)->nullable();
            $table->decimal('one_day_region_driver', 10, 0)->nullable();
            $table->decimal('three_day_region_driver', 10, 0)->nullable();
            $table->decimal('seven_day_region_driver', 10, 0)->nullable();
            $table->decimal('thirty_day_region_driver', 10, 0)->nullable();
            $table->decimal('over_thirty_day_region_driver', 10, 0)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_rental_values', function($table)
        {
            $table->dropColumn('one_day_region');
            $table->dropColumn('three_day_region');
            $table->dropColumn('seven_day_region');
            $table->dropColumn('thirty_day_region');
            $table->dropColumn('over_thirty_day_region');
            $table->dropColumn('one_day_region_driver');
            $table->dropColumn('three_day_region_driver');
            $table->dropColumn('seven_day_region_driver');
            $table->dropColumn('thirty_day_region_driver');
            $table->dropColumn('over_thirty_day_region_driver');
        });
    }
}
