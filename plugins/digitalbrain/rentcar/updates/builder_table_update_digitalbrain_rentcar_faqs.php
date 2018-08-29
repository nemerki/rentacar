<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDigitalbrainRentcarFaqs extends Migration
{
    public function up()
    {
        Schema::rename('digitalbrain_rentcar_faq', 'digitalbrain_rentcar_faqs');
        Schema::table('digitalbrain_rentcar_faqs', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::rename('digitalbrain_rentcar_faqs', 'digitalbrain_rentcar_faq');
        Schema::table('digitalbrain_rentcar_faq', function($table)
        {
            $table->increments('id')->unsigned()->change();
        });
    }
}
