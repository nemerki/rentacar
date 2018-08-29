<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarRentalInvoices extends Migration
{
    public function up()
    {
        Schema::rename('digitalbrain_rentcar_rental_invoice', 'digitalbrain_rentcar_rental_invoices');
        Schema::table('digitalbrain_rentcar_rental_invoices', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::rename('digitalbrain_rentcar_rental_invoices', 'digitalbrain_rentcar_rental_invoice');
        Schema::table('digitalbrain_rentcar_rental_invoice', function($table)
        {
            $table->increments('id')->unsigned()->change();
        });
    }
}
