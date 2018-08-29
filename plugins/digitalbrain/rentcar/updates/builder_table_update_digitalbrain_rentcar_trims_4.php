<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarTrims4 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_trims', function($table)
        {
            $table->renameColumn('models_id', 'mdl_id');
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_trims', function($table)
        {
            $table->renameColumn('mdl_id', 'models_id');
        });
    }
}
