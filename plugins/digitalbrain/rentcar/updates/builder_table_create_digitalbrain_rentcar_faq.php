<?php namespace DigitalBrain\RentCar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDigitalbrainRentcarFaq extends Migration
{
    public function up()
    {
        Schema::create('digitalbrain_rentcar_faq', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('question')->nullable();
            $table->text('answer')->nullable();
            $table->integer('sort_order')->nullable()->unsigned();
            $table->boolean('is_active')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('digitalbrain_rentcar_faq');
    }
}
