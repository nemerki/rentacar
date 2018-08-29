<?php namespace JorgeAndrade\SubscribePlus\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCampaignsTable extends Migration
{

    public function up()
    {
        Schema::create('jorgeandrade_subscribeplus_campaigns', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('subject')->nullable();
            $table->longText('html');
            $table->integer('template_id')->default(1);
            $table->integer('list_id')->default(0);
            $table->integer('subscriber_id')->default(0);
            $table->integer('is_launch')->default(0);
            $table->timestamp('launched_at')->nullable();
            $table->integer('status')->default(1);
            $table->integer('is_delay')->default(0);
            $table->timestamp('delayed_at')->nullable();
            $table->integer('is_schelud')->default(0);
            $table->string('scheluded_every')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jorgeandrade_subscribeplus_campaigns');
    }

}
