<?php namespace JorgeAndrade\SubscribePlus\Models;

use Model;

/**
 * Campaign Model
 */
class Campaign extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'jorgeandrade_subscribeplus_campaigns';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'subject', 'html', 'template_id'];

    protected $dates = ['created_at', 'updated_at', 'launched_at', 'delayed_at'];
    /**
     * @var array Relations
     */
    public $belongsTo = [
        'template' => ['JorgeAndrade\SubscribePlus\Models\Template'],
        'list' => ['JorgeAndrade\SubscribePlus\Models\Lists']
    ];

    public $hasMany = [
        'messages' => 'JorgeAndrade\SubscribePlus\Models\Message',
    ];

}