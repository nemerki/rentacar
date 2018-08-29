<?php namespace DigitalBrain\RentCar\Models;

use Model;

/**
 * Model
 */
class EquipmentCar extends Model
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
    public $table = 'digitalbrain_rentcar_equipment_car';
    public $belongsToMany = [
        'cars' => ['DigitalBrain\RentCar\Models\Car', 'table' => 'digitalbrain_rentcar_equipment_car']
    ];

}
