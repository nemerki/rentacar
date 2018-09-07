<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarTransferInvoices extends Migration
{
    public function up()
    {
        Schema::table('digitalbrain_rentcar_transfer_invoices', function($table)
        {
            $table->boolean('is_other')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('digitalbrain_rentcar_transfer_invoices', function($table)
        {
            $table->dropColumn('is_other');
        });
    }
}
