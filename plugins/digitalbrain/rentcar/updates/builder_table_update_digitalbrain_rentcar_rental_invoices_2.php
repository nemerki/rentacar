<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarRentalInvoices2 extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_rental_invoices', function($table)
        {
            $table->integer('rental_id')->nullable()->change();
            $table->decimal('car_rent', 10, 0)->nullable()->change();
            $table->decimal('service_tax', 10, 0)->nullable()->change();
            $table->decimal('edv', 10, 0)->nullable()->change();
            $table->decimal('total_amount_payable', 10, 0)->nullable()->change();
            $table->decimal('net_amount_payable', 10, 0)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_rental_invoices', function($table)
        {
            $table->integer('rental_id')->nullable(false)->change();
            $table->decimal('car_rent', 10, 0)->nullable(false)->change();
            $table->decimal('service_tax', 10, 0)->nullable(false)->change();
            $table->decimal('edv', 10, 0)->nullable(false)->change();
            $table->decimal('total_amount_payable', 10, 0)->nullable(false)->change();
            $table->decimal('net_amount_payable', 10, 0)->nullable(false)->change();
        });
    }
}
