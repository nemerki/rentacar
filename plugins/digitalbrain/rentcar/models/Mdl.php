<?php namespace DigitalBrain\RentCar\Models;

use Model;

/**
 * Model
 */
class Mdl extends Model
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
    public $table = 'digitalbrain_rentcar_mdls';
    /**
     * Softly implement the TranslatableModel behavior.
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var array Attributes that support translation, if available.
     */
    public $translatable = ['name'];


    public $belongsTo = [
        'brand' => ['DigitalBrain\RentCar\Models\Brand']
    ];

    public $hasMany = [
        'trims' => ['DigitalBrain\RentCar\Models\Trim', 'softDelete' => true],
        'cars' => ['DigitalBrain\RentCar\Models\Car', 'softDelete' => true],
    ];
}


