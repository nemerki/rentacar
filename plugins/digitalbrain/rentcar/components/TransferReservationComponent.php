<?php namespace DigitalBrain\RentCar\Components;

use Cms\Classes\ComponentBase;
use DigitalBrain\RentCar\Models\Car;
use DigitalBrain\RentCar\Models\Transfer;
use RainLab\User\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class TransferReservationComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'TransferReservation',
            'description' => 'Transfer Reservation Page Component'
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
        $this->page['price'] = Session::get('price');
        $this->page['is_city'] = Session::get('is_city');

    }

    protected function listCar()
    {
        $car_id = Session::get('car_id');

        return $model = Car::where('id', $car_id)->with(['brand', 'mdl', 'trim'])->first();

    }

    public function onSave()
    {


        $data = Input::only('car_id', 'start_date', 'name', 'phone', 'address', 'remarks', 'seller_id');
        $data['user_id'] = Auth::getUser()->id;
        $invoice = Input::only('car_transfer_price', 'service_tax', 'edv', 'total_amount_payable', 'is_city', 'is_airport','is_other');


        $model = Transfer::create($data);
        $model->transfer_invoice()->create($invoice);
    }
}
