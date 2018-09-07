<?php namespace DigitalBrain\RentCar\Components;

use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use DatePeriod;
use DateTime;
use DateInterval;
use DigitalBrain\RentCar\Models\Ban;
use DigitalBrain\RentCar\Models\Brand;
use DigitalBrain\RentCar\Models\Car;
use DigitalBrain\RentCar\Models\City;
use DigitalBrain\RentCar\Models\Color;
use DigitalBrain\RentCar\Models\EngineVolume;
use DigitalBrain\RentCar\Models\EquipmentCategory;
use DigitalBrain\RentCar\Models\Fuel;
use DigitalBrain\RentCar\Models\Mdl;
use DigitalBrain\RentCar\Models\Rental;
use DigitalBrain\RentCar\Models\Seat;
use DigitalBrain\RentCar\Models\Transmision;
use DigitalBrain\RentCar\Models\Wheel;
use DigitalBrain\RentCar\Models\Year;

use ValidationException;
use Validator;
use Illuminate\Support\Facades\Input;

class AddNewCarComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Add New Car',
            'description' => 'Add new car page component'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {


        $this->page['brands'] = $this->listBrand();
        $this->page['years'] = $this->listYear();
        $this->page['fuels'] = $this->listFuel();
        $this->page['transmisions'] = $this->listTransmision();
        $this->page['wheels'] = $this->listWheel();
        $this->page['engine_volumes'] = $this->listEngineVolume();
        $this->page['bans'] = $this->listBan();
        $this->page['colors'] = $this->listColor();
        $this->page['seats'] = $this->listSeat();
        $this->page['equipmentCategories'] = $this->listEquipmentCategory();
        $this->page['cities'] = $this->listCity();


    }

    protected function listCity()
    {
        $model = new City();
        return $model->orderBy('sort_order', 'ASC')->get();
    }

    protected function listSeat()
    {
        $model = new Seat();
        return $model->orderBy('number', 'ASC')->get();
    }

    protected function listEquipmentCategory()
    {
        $model = new EquipmentCategory();
        return $model->orderBy('sort_order', 'ASC')->get();
    }

    protected function listColor()
    {
        $model = new Color();
        return $model->orderBy('name', 'ASC')->get();
    }

    protected function listBrand()
    {
        $model = new Brand();
        return $model->orderBy('name', 'ASC')->get();
    }

    protected function listBan()
    {
        $model = new Ban();
        return $model->orderBy('name', 'ASC')->get();
    }

    protected function listYear()
    {
        $model = Year::orderBy('year', 'ASC')->get();
        return $model;
    }

    protected function listFuel()
    {
        $model = Fuel::all();
        return $model;
    }

    protected function listTransmision()
    {
        $model = Transmision::all();
        return $model;
    }

    protected function listWheel()
    {
        $model = Wheel::all();
        return $model;
    }

    protected function listEngineVolume()
    {
        $model = EngineVolume::all();
        return $model;
    }

    public function onModel()
    {
        $brand_id = post('brand_id');
        $model = Brand::where('id', $brand_id)->first();
        $this->page['models'] = $model->mdls;

    }

    public function onTrim()
    {
        $model_id = post('model_id');
        $model = Mdl::where('id', $model_id)->first();
        $this->page['trims'] = $model->trims;
    }

    public function onCarSave()
    {
        $validateData = post();
        if (post('is_rent') == '1') {
            $rules = [
                'brand_id' => 'required',
                'mdl_id' => 'required',
                'year_id' => 'required',
                'fuel_id' => 'required',
                'transmision_id' => 'required',
                'wheel_id' => 'required',
                'engine_volume_id' => 'required',
                'city_id' => 'required',
                'street_address' => 'required',
                'ban_id' => 'required',
                'color_id' => 'required',
                'seat_id' => 'required',
                'term' => 'accepted',
                'kasko' => 'accepted',
                'one_day' => 'required',
            ];
        } else {
            $rules = [
                'brand_id' => 'required',
                'mdl_id' => 'required',
                'year_id' => 'required',
                'fuel_id' => 'required',
                'transmision_id' => 'required',
                'wheel_id' => 'required',
                'engine_volume_id' => 'required',
                'city_id' => 'required',
                'street_address' => 'required',
                'ban_id' => 'required',
                'color_id' => 'required',
                'seat_id' => 'required',
                'term' => 'accepted',
                'kasko' => 'accepted',
                'city' => 'required',
            ];
        }

        $validation = Validator::make($validateData, $rules);

        if ($validation->fails()) {
            throw new ValidationException($validation);

        } else {


            $transfer_value = Input::only('city', 'airport');

            $rental_value = Input::only('one_day', 'one_day_driver','one_day_region','one_day_region_driver', 'three_day', 'three_day_driver','three_day_region','three_day_region_driver', 'seven_day', 'seven_day_driver', 'seven_day_region','seven_day_region_driver',  'thirty_day', 'thirty_day_driver','thirty_day_region', 'thirty_day_region_driver','over_thirty_day', 'over_thirty_day_driver','over_thirty_day_region','over_thirty_day_region_driver');
            $location = Input::only('lat', 'lan', 'street_address', 'city_id');
            $equipment_id = post('equipment_id');

            $data = Input::except('kasko', 'term', 'equipment_id', 'lat', 'lan', 'street_address', 'city_id', 'city', 'airport', 'one_day', 'one_day_driver','one_day_region','one_day_region_driver', 'three_day', 'three_day_driver','three_day_region','three_day_region_driver', 'seven_day', 'seven_day_driver', 'seven_day_region','seven_day_region_driver',  'thirty_day', 'thirty_day_driver','thirty_day_region', 'thirty_day_region_driver','over_thirty_day', 'over_thirty_day_driver','over_thirty_day_region','over_thirty_day_region_driver');
            $car = Car::create($data);
            $car->location()->create($location);

            $car->rental_value()->create($rental_value);
            $car->transfer_value()->create($transfer_value);
            $car->equipments()->attach($equipment_id);

        }
    }

}
