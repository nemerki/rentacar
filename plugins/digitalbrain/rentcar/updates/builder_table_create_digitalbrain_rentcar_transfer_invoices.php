<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDigitalbrainRentcarTransferInvoices extends Migration
{
    public function up()
    {
        Schema::create('digitalbrain_rentcar_transfer_invoices', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('transfer_id')->nullable()->unsigned();
            $table->decimal('car_transfer_price', 10, 2)->nullable();
            $table->decimal('service_tax', 10, 2);
            $table->decimal('edv', 10, 2);
            $table->decimal('total_amount_payable', 10, 2);
            $table->decimal('discount_amount', 10, 2);
            $table->decimal('net_amount_payable', 10, 2);
            $table->boolean('is_city')->default(0);
            $table->boolean('is_airport')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('digitalbrain_rentcar_transfer_invoices');
    }
}
