<?php namespace DigitalBrain\RentCar\Models;

use Model;

/**
 * Model
 */
class Insurance extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Sortable;

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    /**
     * @var string The database table used by the model.
     */
    public $table = 'digitalbrain_rentcar_insurances';
    /**
     * Softly implement the TranslatableModel behavior.
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    /**
     * @var array Attributes that support translation, if available.
     */
    public $translatable = ['name'];
    protected $dates = ['deleted_at'];


    public $hasMany = [
        'cars' => ['DigitalBrain\RentCar\Models\Car', 'softDelete' => true],
    ];


}
