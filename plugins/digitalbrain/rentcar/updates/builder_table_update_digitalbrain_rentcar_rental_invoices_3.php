<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarRentalInvoices3 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_rental_invoices', function($table)
        {
            $table->integer('rental_id')->unsigned()->change();
            $table->renameColumn('car_rent', 'car_rent_price');
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_rental_invoices', function($table)
        {
            $table->integer('rental_id')->unsigned(false)->change();
            $table->renameColumn('car_rent_price', 'car_rent');
        });
    }
}
