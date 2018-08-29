<?php namespace JorgeAndrade\SubscribePlus\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMessageOpensTable extends Migration
{

    public function up()
    {
        Schema::create('jorgeandrade_subscribeplus_message_opens', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('message_id');
            $table->string('ip_address');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jorgeandrade_subscribeplus_message_opens');
    }

}
