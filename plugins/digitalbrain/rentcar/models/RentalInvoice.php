<?php namespace DigitalBrain\RentCar\Models;

use Model;

/**
 * Model
 */
class RentalInvoice extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];
    protected $guarded = [];
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'digitalbrain_rentcar_rental_invoices';
    public $belongsTo = [
        'rental' => ['DigitalBrain\RentCar\Models\Rental']
    ];
}
