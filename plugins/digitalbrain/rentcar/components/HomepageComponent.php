<?php namespace DigitalBrain\RentCar\Components;

use Cms\Classes\ComponentBase;
use DigitalBrain\RentCar\Models\Ban;
use DigitalBrain\RentCar\Models\Brand;
use DigitalBrain\RentCar\Models\City;
use DigitalBrain\RentCar\Models\RentalValue;
use DigitalBrain\RentCar\Models\Year;
use Illuminate\Support\Facades\Session;

class HomepageComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Homepage',
            'description' => 'Homepage Component'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {

        $this->page['price'] = $this->listPrice();
        $this->page['brands'] = $this->listBrand();
        $this->page['years'] = $this->listYear();
        $this->page['bans'] = $this->listBan();
        $this->page['cities'] = $this->listCity();
    }

    protected function listBan()
    {
        $model = new Ban();
        return $model->orderBy('name', 'ASC')->get();
    }

    protected function listPrice()
    {
        $model = new RentalValue();
        $this->page['priceMax'] = $model->max('one_day');
        $this->page['priceMin'] = $model->min('one_day');
    }

    protected function listCity()
    {
        $model = new City();
        return $model->orderBy('sort_order', 'ASC')->get();
    }

    protected function listYear()
    {
        $model = Year::orderBy('year', 'ASC')->get();
        $this->page['yearsMax'] = $model->max('year');
        $this->page['yearsMin'] = $model->min('year');
        return $model;
    }

    protected function listBrand()
    {
        $model = new Brand();
        return $model->orderBy('name', 'ASC')->get();
    }

    public function onModel()
    {
        $this->brand_id = $brand_id = post('brand_id');
        $model = Brand::where('id', $brand_id)->first();
        $this->page['models'] = $model->mdls;
//        $car = Car::where('brand_id', $brand_id)->where('is_active', '1')->paginate(1);
//        $this->page['partialsRecords'] = $car;
//        $this->page['filterClass'] = 'filterAjaxPagination';
    }

    public function onSearch()
    {
        $ban_id = post('ban_id');
        $city_id = post('city_id');
        $brand_id = post('brand_id');
        $mdl_id = post('mdl_id');
        $price = post('price');
        $is_rent = post('is_rent');

        if ($ban_id) {
            Session::flash('ban_id', $ban_id);
        }
        if ($city_id) {
            Session::flash('city_id', $city_id);
        }
        if ($brand_id) {
            Session::flash('brand_id', $brand_id);
        }
        if ($mdl_id) {
            Session::flash('mdl_id', $mdl_id);
        }
        if ($price) {
            Session::flash('price', $price);
        }

        Session::flash('homeFilter', "1");


        if ($is_rent == 1) {
            return ["status" => "rent"];
        } elseif ($is_rent == 0) {
            return ["status" => "transfer"];
        }

    }

}
