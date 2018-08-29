<?php namespace JorgeAndrade\SubscribePlus\Models;

use Model;

/**
 * List Model
 */
class Lists extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'jorgeandrade_subscribeplus_lists';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'subscribers' => ['JorgeAndrade\Subscribe\Models\Subscriber', 'table' => 'jorgeandrade_subscribeplus_lists_subscribers']
    ];

    public function getSubscriberCountAttribute()
    {
        return $this->subscribers()->count();
    }

}