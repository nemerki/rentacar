<?php namespace JorgeAndrade\SubscribePlus\Models;

use Model;

/**
 * Template Model
 */
class Template extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'jorgeandrade_subscribeplus_templates';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'code', 'html', 'html_preview', 'is_default'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}