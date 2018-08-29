<?php namespace JorgeAndrade\SubscribePlus\Models;

use Model;
use Carbon\Carbon;

/**
 * Message Model
 */
class Message extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'jorgeandrade_subscribeplus_messages';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['subscriber_id', 'subject', 'html', 'campaign_id', 'is_send', 'send_at', 'hash'];
    /**
     * @var array Relations
     */
    public $hasMany = [
        'opens' => 'JorgeAndrade\SubscribePlus\Models\MessageOpen',
    ];

    public $belongsTo = [
        'subscriber' => ['JorgeAndrade\Subscribe\Models\Subscriber'],
    ];

    public function beforeCreate()
    {
        $this->is_send = 1;
        $this->send_at = Carbon::now();
        $this->hash = md5(time().'emailed'.rand(1, 10000));
    }

    public function logEmailOpened()
    {
        $this->opens()->create([]);
    }

}