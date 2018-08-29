<?php namespace JorgeAndrade\SubscribePlus\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTemplatesTable extends Migration
{

    public function up()
    {
        Schema::create('jorgeandrade_subscribeplus_templates', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->longText('html');
            $table->longText('html_preview')->nullable();
            $table->integer('is_default')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jorgeandrade_subscribeplus_templates');
    }

}
