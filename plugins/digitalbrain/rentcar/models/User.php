<?php namespace DigitalBrain\RentCar\Models;

use Model;

/**
 * User Model
 */
class User extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'users';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Relations
     */
    /*    public $hasOne = [];
        public $hasMany = [];
        public $belongsTo = [];
        public $belongsToMany = [];
        public $morphTo = [];
        public $morphOne = [];
        public $morphMany = [];
        public $attachOne = [];
        public $attachMany = [];*/

    public $hasMany = [
        'cars' => ['DigitalBrain\RentCar\Models\Car', 'softDelete' => true],
        'rentals' => ['DigitalBrain\RentCar\Models\Rental', 'softDelete' => true],
        'transfers' => ['DigitalBrain\RentCar\Models\Transfer', 'softDelete' => true],
    ];

    public function getRentTotalPriceAttribute()
    {


        $a = 0;
        foreach ($this->rentals as $rental) {
            $a = $a + $rental->rental_invoice->total_amount_payable;
        }
        return $a;

    }

    public function getTransferTotalPriceAttribute()
    {


        $a = 0;
        foreach ($this->transfers as $transfer) {
            $a = $a + $transfer->transfer_invoice->total_amount_payable;
        }
        return $a;

    }

    public function getCountRentAttribute()
    {
        $rent = User::with('rentals')
            ->withCount('rentals')
            ->orderBy('rentals_count', 'desc')
            ->take(100)->get();


        return $rent;

    }

    public function getCountTransferAttribute()
    {
        $transfer = User::with('transfers')
            ->withCount('transfers')
            ->orderBy('transfers_count', 'desc')
            ->take(100)->get();


        return $transfer;

    }


    public function getFullNameAttribute()
    {
        $name = $this->name;
        if ($this->surname) {
            $surname = $this->surname;
        } else {
            $surname = "";
        }

        return "{$name} {$surname}";
    }
}
