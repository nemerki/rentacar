<?php namespace DigitalBrain\RentCar\Components;

use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use DatePeriod;
use DateTime;
use DateInterval;
use DigitalBrain\RentCar\Models\Car;
use DigitalBrain\RentCar\Models\EquipmentCategory;
use DigitalBrain\RentCar\Models\Rental;
use DigitalBrain\RentCar\Models\Transfer;
use Illuminate\Support\Facades\Session;

class CarDetailComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Car Detail Component',
            'description' => 'Car Detail Page Component'
        ];
    }

    public function defineProperties()
    {
        return [];
    }


    public function onRun()
    {

        $this->page['equipmentCategories'] = $this->listEquipmentCategory();
        $this->page['disableDays'] = $this->disableDay();
        $this->page['disableTransferDays'] = $this->disableTransferDays();
        $this->page['sameMdls'] = $this->sameMdl();


    }

    protected function sameMdl()
    {
        $slug = $this->page['identifierValue'];

        $car = Car::where('slug', $slug)->withTrashed()->first();
        $id = $car->id;
        $mdl_id = $car->mdl_id;
        if ($car->is_transfer == 1) {
            $model = Car::where('confirm', '1')
                ->where('is_published', '1')
                ->where('is_transfer', '1')
                ->where('id', '<>', $id)
                ->where('mdl_id', $mdl_id)
                ->orderBy('created_at', 'DESC')
                ->take(4)
                ->get();
            return $model;
        } else {
            $model = Car::where('confirm', '1')
                ->where('is_published', '1')
                ->where('is_rent', '1')
                ->where('id', '<>', $id)
                ->where('mdl_id', $mdl_id)
                ->orderBy('created_at', 'DESC')
                ->take(4)
                ->get();
            return $model;
        }
    }

    protected function disableTransferDays()
    {
        $slug = $this->page['identifierValue'];
        $car = Car::where('slug', $slug)->withTrashed()->first();
        $modals = Transfer::where('start_date', '>=', Carbon::now())->where('car_id', $car->id)->get();
        $disableTransferDays = [];
        foreach ($modals as $modal) {
            $begin = new DateTime($modal->start_date);
            $disableTransferDays[] = $begin->format("d.m.Y");

        }
        $disableTransferDays = array_unique($disableTransferDays);

        return $disableTransferDays;
    }

    protected function disableDay()
    {
        $slug = $this->page['identifierValue'];
        $car = Car::where('slug', $slug)->withTrashed()->first();
        $modals = Rental::where('start_date', '>=', Carbon::now())->where('car_id', $car->id)->get();
        $disableDay = [];
        foreach ($modals as $modal) {

            $begin = new DateTime($modal->start_date);
            $end = new DateTime($modal->end_date);

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            foreach ($period as $dt) {
                $disableDay[] = $dt->format("Y/m/d");
            }
        }
        $disableDay = array_unique($disableDay);
        return $disableDay;

    }

    protected function listEquipmentCategory()
    {
        $model = new EquipmentCategory();
        return $model->orderBy('sort_order', 'ASC')->get();
    }

    public function onSession()
    {
        $car_id = post('car_id');
        $price = post('price');
        $days = post('days');
        $endDate = post('endDate');
        $startDate = post('startDate');
        $rent_method = post('rent_method');
        Session::put('car_id', $car_id);
        Session::put('price', $price);
        Session::put('days', $days);
        Session::put('endDate', $endDate);
        Session::put('startDate', $startDate);
        Session::put('rent_method', $rent_method);

    }

    public function onSessionTransfer()
    {
        $car_id = post('car_id');
        $price = post('price');
        $startDate = post('startDate');
        $is_city = post('is_city');


        Session::put('car_id', $car_id);
        Session::put('price', $price);
        Session::put('startDate', $startDate);
        Session::put('is_city', $is_city);

    }
}
