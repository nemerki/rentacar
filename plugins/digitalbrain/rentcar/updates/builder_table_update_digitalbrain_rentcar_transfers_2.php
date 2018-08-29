<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarTransfers2 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_transfers', function($table)
        {
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_transfers', function($table)
        {
            $table->dropColumn('name');
            $table->dropColumn('phone');
            $table->dropColumn('address');
        });
    }
}
