<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarRentalInvoices4 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_rental_invoices', function($table)
        {
            $table->decimal('car_rent_price', 10, 2)->change();
            $table->decimal('service_tax', 10, 2)->change();
            $table->decimal('edv', 10, 2)->change();
            $table->decimal('total_amount_payable', 10, 2)->change();
            $table->decimal('discount_amount', 10, 2)->change();
            $table->decimal('net_amount_payable', 10, 2)->change();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_rental_invoices', function($table)
        {
            $table->decimal('car_rent_price', 10, 0)->change();
            $table->decimal('service_tax', 10, 0)->change();
            $table->decimal('edv', 10, 0)->change();
            $table->decimal('total_amount_payable', 10, 0)->change();
            $table->decimal('discount_amount', 10, 0)->change();
            $table->decimal('net_amount_payable', 10, 0)->change();
        });
    }
}
