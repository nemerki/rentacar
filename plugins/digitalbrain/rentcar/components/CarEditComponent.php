<?php namespace DigitalBrain\RentCar\Components;

use Cms\Classes\ComponentBase;
use DigitalBrain\RentCar\Models\Ban;
use DigitalBrain\RentCar\Models\Brand;
use DigitalBrain\RentCar\Models\Car;
use DigitalBrain\RentCar\Models\City;
use DigitalBrain\RentCar\Models\Color;
use DigitalBrain\RentCar\Models\EngineVolume;
use DigitalBrain\RentCar\Models\EquipmentCategory;
use DigitalBrain\RentCar\Models\Fuel;
use DigitalBrain\RentCar\Models\Mdl;
use DigitalBrain\RentCar\Models\Seat;
use DigitalBrain\RentCar\Models\Transmision;
use DigitalBrain\RentCar\Models\Wheel;
use DigitalBrain\RentCar\Models\Year;
use Validator;
use Illuminate\Support\Facades\Input;
use ValidationException;


class CarEditComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'CarEdit',
            'description' => 'Car Edit Page Component'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $slug = $this->param('slug');
        $car = Car::where('slug', $slug)->first();
        $this->page['car'] = $car;


        $brand_id = $car->brand_id;
        $model = Brand::where('id', $brand_id)->first();
        $this->page['models'] = $model->mdls;

        if ($car->trim_id) {
            $model_id = $car->mdl_id;
            $model = Mdl::where('id', $model_id)->first();
            $this->page['trims'] = $model->trims;
        }

        /*önceden seçilmiş equipmentları checked elemek üçün*/
        $equipments = [];
        foreach ($car->equipments as $equipment) {
            $equipments[] = $equipment->id;

        }
        $this->page['equipments'] = $equipments;


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

    public function onCarUpdate()
    {

        $validateData['image'] = Input::file('image');
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
                'image' => 'required',
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
                'image' => 'required',
            ];
        }

        $validation = Validator::make($validateData, $rules);

        if ($validation->fails()) {
            throw new ValidationException($validation);

        } else {


            $slug = $this->param('slug');

            $transfer_value = Input::only('city', 'airport');

            $rental_value = Input::only('one_day', 'one_day_driver', 'three_day', 'three_day_driver', 'seven_day', 'seven_day_driver', 'thirty_day', 'thirty_day_driver', 'over_thirty_day', 'over_thirty_day_driver');
            $location = Input::only('lat', 'lan', 'street_address', 'city_id');
            $equipment_id = post('equipment_id');

            $data = Input::except('equipment_id', 'lat', 'lan', 'street_address', 'city_id', 'city', 'airport', 'one_day', 'one_day_driver', 'three_day', 'three_day_driver', 'seven_day', 'seven_day_driver', 'thirty_day', 'thirty_day_driver', 'over_thirty_day', 'over_thirty_day_driver');
            $car = Car::where('slug', $slug)->first();
//        File::where('attachment_type', 'DigitalBrain\RentCar\Models\Car')->where('attachment_id', $car->id)->delete();
            $car->update($data);

            $car->rental_value()->update($rental_value);
            $car->location()->update($location);
            $car->transfer_value()->update($transfer_value);
            $car->equipments()->sync($equipment_id);

        }


    }

}
