<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarTrims3 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_trims', function($table)
        {
            $table->renameColumn('model_id', 'models_id');
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_trims', function($table)
        {
            $table->renameColumn('models_id', 'model_id');
        });
    }
}
