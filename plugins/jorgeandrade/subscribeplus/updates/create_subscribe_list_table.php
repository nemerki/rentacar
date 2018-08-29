<?php namespace JorgeAndrade\SubscribePlus\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateSubscribeListTable extends Migration
{

    public function up()
    {
        Schema::create('jorgeandrade_subscribeplus_lists_subscribers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('lists_id')->unsigned();
            $table->integer('subscriber_id')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jorgeandrade_subscribeplus_lists_subscribers');
    }

}
