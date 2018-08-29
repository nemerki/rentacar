<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarRentals3 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_rentals', function($table)
        {
            $table->dateTime('start_date')->nullable()->unsigned(false)->default(null)->change();
            $table->dateTime('end_date')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_rentals', function($table)
        {
            $table->date('start_date')->nullable()->unsigned(false)->default(null)->change();
            $table->date('end_date')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
