<?php namespace JorgeAndrade\SubscribePlus\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateListsTable extends Migration
{

    public function up()
    {
        Schema::create('jorgeandrade_subscribeplus_lists', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('default_email');
            $table->string('default_name');
            $table->text('comments');
            $table->text('contact_info');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jorgeandrade_subscribeplus_lists');
    }

}
