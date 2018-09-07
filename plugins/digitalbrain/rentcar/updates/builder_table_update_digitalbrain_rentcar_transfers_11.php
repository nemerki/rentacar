<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarTransfers11 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_transfers', function($table)
        {
            $table->text('rejected_comment')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_transfers', function($table)
        {
            $table->dropColumn('rejected_comment');
        });
    }
}
