<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarRentalInvoices5 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_rental_invoices', function($table)
        {
            $table->integer('day')->nullable()->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_rental_invoices', function($table)
        {
            $table->dropColumn('day');
        });
    }
}
