<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarRentalValues extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_rental_values', function($table)
        {
            $table->decimal('one_day_driver', 10, 0)->nullable();
            $table->decimal('three_day_driver', 10, 0)->nullable();
            $table->decimal('seven_day_driver', 10, 0)->nullable();
            $table->decimal('thirty_day_driver', 10, 0)->nullable();
            $table->decimal('over_thirty_day_driver', 10, 0)->nullable();
            $table->increments('id')->unsigned(false)->change();
            $table->decimal('one_day', 10, 0)->nullable()->change();
            $table->decimal('three_day', 10, 0)->nullable()->change();
            $table->decimal('seven_day', 10, 0)->nullable()->change();
            $table->decimal('thirty_day', 10, 0)->nullable()->change();
            $table->decimal('over_thirty_day', 10, 0)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_rental_values', function($table)
        {
            $table->dropColumn('one_day_driver');
            $table->dropColumn('three_day_driver');
            $table->dropColumn('seven_day_driver');
            $table->dropColumn('thirty_day_driver');
            $table->dropColumn('over_thirty_day_driver');
            $table->increments('id')->unsigned()->change();
            $table->decimal('one_day', 10, 0)->nullable(false)->change();
            $table->decimal('three_day', 10, 0)->nullable(false)->change();
            $table->decimal('seven_day', 10, 0)->nullable(false)->change();
            $table->decimal('thirty_day', 10, 0)->nullable(false)->change();
            $table->decimal('over_thirty_day', 10, 0)->nullable(false)->change();
        });
    }
}
