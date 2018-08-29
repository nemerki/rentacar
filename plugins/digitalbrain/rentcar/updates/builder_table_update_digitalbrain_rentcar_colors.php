<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarColors extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_colors', function($table)
        {
            $table->string('color_code')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_colors', function($table)
        {
            $table->dropColumn('color_code');
        });
    }
}
