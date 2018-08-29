<?php namespace DigitalBrain\RentCar\Models;

use Model;

/**
 * Model
 */
class Location extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    protected $guarded = [];
    /**
     * @var string The database table used by the model.
     */
    public $table = 'digitalbrain_rentcar_locations';

    public $belongsTo = [
        'car' => ['DigitalBrain\RentCar\Models\Car'],
        'city' => ['DigitalBrain\RentCar\Models\City'],
    ];
}
