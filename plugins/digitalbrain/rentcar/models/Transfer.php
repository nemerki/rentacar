<?php namespace DigitalBrain\RentCar\Models;

use Model;

/**
 * Model
 */
class Transfer extends Model
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
    public $table = 'digitalbrain_rentcar_transfers';
    public $hasOne = [
        'transfer_invoice' => ['DigitalBrain\RentCar\Models\TransferInvoice'],
    ];


    public $belongsTo = [
        'car' => ['DigitalBrain\RentCar\Models\Car'],
        'user' => ['RainLab\User\Models\User'],
    ];

    public function getTitleAttribute()
    {
        $brand = $this->car->brand->name;
        $model = $this->car->mdl->name;
        if ($this->car->trim) {
            $trim = $this->car->trim->name;
        } else {
            $trim = "";
        }
        return $brand . " " . $model . " " . $trim;
    }

    public function getPriceAttribute()
    {
        $price = $this->transfer_invoice->total_amount_payable;

        return $price;
    }
}
