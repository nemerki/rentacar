<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarTransfers10 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_transfers', function($table)
        {
            $table->integer('seller_id')->nullable()->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_transfers', function($table)
        {
            $table->dropColumn('seller_id');
        });
    }
}
