<?php namespace JorgeAndrade\SubscribePlus\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMessagesTable extends Migration
{

    public function up()
    {
        Schema::create('jorgeandrade_subscribeplus_messages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('subscriber_id');
            $table->string('subject');
            $table->longText('html');
            $table->integer('campaign_id');
            $table->integer('is_send')->default(0);
            $table->timestamp('send_at')->nullable();
            $table->integer('is_bounce')->default(0);
            $table->string('hash')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jorgeandrade_subscribeplus_messages');
    }

}
