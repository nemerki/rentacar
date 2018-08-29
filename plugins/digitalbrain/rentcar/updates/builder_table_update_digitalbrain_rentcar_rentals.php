<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarRentals extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_rentals', function($table)
        {
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('confirm')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_rentals', function($table)
        {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('confirm');
        });
    }
}
