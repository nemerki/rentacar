<?php namespace DigitalBrain\RentCar\Models;

use Model;

/**
 * Model
 */
class Rental extends Model
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
    public $table = 'digitalbrain_rentcar_rentals';
    public $hasOne = [
        'rental_invoice' => ['DigitalBrain\RentCar\Models\RentalInvoice'],
    ];
    public $belongsTo = [
        'car' => ['DigitalBrain\RentCar\Models\Car'],
        'user' => ['RainLab\User\Models\User'],
    ];

    public function getTitleAttribute()
    {
        $brand = $this->car()->withTrashed()->first()->brand->name;
        $model = $this->car()->withTrashed()->first()->mdl->name;
        if ($this->car()->withTrashed()->first()->trim) {
            $trim = $this->car()->withTrashed()->first()->trim->name;
        } else {
            $trim = "";
        }
        return $brand . " " . $model . " " . $trim;
    }

    public function getPriceAttribute()
    {
        $price = $this->rental_invoice->total_amount_payable;

        return $price ;
    }


    public function getStatusAttribute()
    {
        $confirm = $this->confirm;
        if ($confirm == "0") {
            $status = "Waiting Confirmation ";
        } elseif ($confirm == "1") {
            $status = "Confirmed";
        } elseif ($confirm == "2") {
            $status = "Rejected";
        }
        return $confirm;
    }

}
