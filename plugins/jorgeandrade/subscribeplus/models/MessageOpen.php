<?php namespace JorgeAndrade\SubscribePlus\Models;

use Model;
use Request;

/**
 * MessageOpen Model
 */
class MessageOpen extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'jorgeandrade_subscribeplus_message_opens';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    public function beforeCreate()
    {
        $this->ip_address = Request::getClientIp();
    }

}