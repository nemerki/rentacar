<?php namespace DigitalBrain\RentCar\Models;

use Model;

/**
 * Model
 */
class Car extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    use \October\Rain\Database\Traits\Sluggable;


    /**
     * @var array Generate slugs for these attributes.
     */

    protected $slugs = ['slug' => 'my_slug'];

    /*her maşına özel slug üçün yazdım bunu car tablosunda my_slug model id ile eynidi hiddn
    olaraq model id valusun my_slug a verdim atribut ile de benzersiz bir slug oluşturdum
     my_slug çağırınca aşağıdakı kimi bir slug oluşturur */

    public function getMySlugAttribute($value)
    {
        $model = \DigitalBrain\RentCar\Models\Mdl::where('id', $value)->first();
        if ($model !=null){
            $models = $model->name;
            $brand = $model->brand->name;
            $randNumber = rand(1000, 999999);
            $slug = "p" . $randNumber . "-" . $brand . "-" . $models;
            return $slug;
        }


    }

    protected $dates = ['deleted_at'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    protected $guarded = [];
    protected $jsonable = ['other_equipment'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'digitalbrain_rentcar_cars';

    public $belongsTo = [
        'brand' => ['DigitalBrain\RentCar\Models\Brand'],
        'ban' => ['DigitalBrain\RentCar\Models\Ban'],
        'mdl' => ['DigitalBrain\RentCar\Models\Mdl', 'key' => 'mdl_id'],
        'trim' => ['DigitalBrain\RentCar\Models\Trim'],
        'color' => ['DigitalBrain\RentCar\Models\Color'],
        'fuel' => ['DigitalBrain\RentCar\Models\Fuel'],
        'engine_volume' => ['DigitalBrain\RentCar\Models\EngineVolume'],
        'year' => ['DigitalBrain\RentCar\Models\Year'],
        'wheel' => ['DigitalBrain\RentCar\Models\Wheel'],
        'insurance' => ['DigitalBrain\RentCar\Models\Insurance'],
        'seat' => ['DigitalBrain\RentCar\Models\Seat'],
        'transmision' => ['DigitalBrain\RentCar\Models\Transmision'],
        'user' => ['RainLab\User\Models\User'],


    ];

    public $hasOne = [
        'location' => ['DigitalBrain\RentCar\Models\Location', 'softDelete' => true],
        'rental_value' => ['DigitalBrain\RentCar\Models\RentalValue', 'softDelete' => true],
        'transfer_value' => ['DigitalBrain\RentCar\Models\TransferValue', 'softDelete' => true],
    ];

    public $belongsToMany = [
        'equipments' => ['DigitalBrain\RentCar\Models\Equipment', 'table' => 'digitalbrain_rentcar_equipment_car']
    ];

    public $attachOne = [
        'image' => 'System\Models\File',
        'gallery1' => 'System\Models\File',
        'gallery2' => 'System\Models\File',
        'gallery3' => 'System\Models\File',
        'gallery4' => 'System\Models\File',
        'gallery5' => 'System\Models\File',
        'gallery6' => 'System\Models\File',
        'gallery7' => 'System\Models\File',
        'gallery8' => 'System\Models\File',
        'gallery9' => 'System\Models\File',
        'gallery10' => 'System\Models\File',
        'gallery11' => 'System\Models\File',
        'gallery12' => 'System\Models\File',
        'gallery13' => 'System\Models\File',
        'gallery14' => 'System\Models\File',
        'gallery15' => 'System\Models\File',
    ];

}
