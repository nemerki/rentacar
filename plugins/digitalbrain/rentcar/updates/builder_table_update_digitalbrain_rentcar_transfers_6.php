<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarTransfers6 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_transfers', function($table)
        {
            $table->dateTime('start_date')->nullable()->unsigned(false)->default(null)->change();
            $table->string('phone')->change();
            $table->dropColumn('end_date');
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_transfers', function($table)
        {
            $table->date('start_date')->nullable()->unsigned(false)->default(null)->change();
            $table->string('phone', 191)->change();
            $table->date('end_date')->nullable();
        });
    }
}
