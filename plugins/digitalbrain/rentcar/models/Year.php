<?php namespace DigitalBrain\RentCar\Models;

use Model;

/**
 * Model
 */
class Year extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Sortable;

    protected $dates = ['deleted_at'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'digitalbrain_rentcar_years';

    public $hasMany = [
        'cars' => ['DigitalBrain\RentCar\Models\Car', 'softDelete' => true],
    ];


}
