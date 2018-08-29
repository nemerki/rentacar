<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDigitalbrainRentcarRentalInvoice extends Migration
{
    public function up()
    {
        Schema::create('digitalbrain_rentcar_rental_invoice', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('rental_id')->unsigned();
            $table->decimal('car_rent', 10, 0);
            $table->decimal('service_tax', 10, 0);
            $table->decimal('edv', 10, 0);
            $table->decimal('total_amount_payable', 10, 0);
            $table->decimal('discount_amount', 10, 0)->nullable();
            $table->decimal('net_amount_payable', 10, 0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('digitalbrain_rentcar_rental_invoice');
    }
}
