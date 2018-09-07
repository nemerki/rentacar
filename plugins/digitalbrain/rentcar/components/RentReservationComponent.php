<?php namespace DigitalBrain\RentCar\Components;

use Cms\Classes\ComponentBase;
use DigitalBrain\RentCar\Models\Car;
use DigitalBrain\RentCar\Models\Rental;
use RainLab\User\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class RentReservationComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Rent Reservation Component',
            'description' => 'Rent Reservation Page Component'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->page['car'] = $this->listCar();
        $this->page['startDate'] = Session::get('startDate');
        $this->page['endDate'] = Session::get('endDate');
        $this->page['days'] = Session::get('days');
        $this->page['price'] = Session::get('price');
        $this->page['rent_method'] = Session::get('rent_method');
    }

    protected function listCar()
    {
        $car_id = Session::get('car_id');

        return $model = Car::where('id', $car_id)->with(['brand', 'mdl', 'trim'])->first();

    }

    public function onSave()
    {
        $data = Input::only('car_id', 'start_date', 'end_date', 'name', 'phone', 'address', 'remarks', 'seller_id', 'rent_method');
        $data['user_id'] = Auth::getUser()->id;
        $invoice = Input::only('car_rent_price', 'service_tax', 'total_amount_payable', 'day');


        $model = Rental::create($data);
        $model->rental_invoice()->create($invoice);

    }
}
