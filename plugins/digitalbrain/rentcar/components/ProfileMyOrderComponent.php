<?php namespace DigitalBrain\RentCar\Components;

use Cms\Classes\ComponentBase;
use DigitalBrain\RentCar\Models\Car;
use DigitalBrain\RentCar\Models\Rental;
use DigitalBrain\RentCar\Models\Transfer;
use Lang;
use RainLab\User\Facades\Auth;
use SystemException;

class ProfileMyOrderComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'ProfileMyOrder',
            'description' => 'Profile My Order Page Component'
        ];
    }

    public function onRun()
    {

        $this->listRecords();


    }


    protected function listRecords()
    {
        //giriş yapan kullanıcıyı bulduk
        $user = Auth::getUser();

        $rentalModel = Rental::with(['rental_invoice', 'car.brand', 'car.mdl', 'car.trim', 'car.year', 'user'])->where('user_id', $user->id)->orderBy("created_at","DESC");
        $transferModel = Transfer::with(['transfer_invoice', 'car.brand', 'car.mdl', 'car.trim', 'car.year', 'user'])->where('user_id', $user->id)->orderBy("created_at","DESC");

        $rentals = $rentalModel->get();
        $transfers = $transferModel->get();

        $this->page['rentals'] = $rentalModel->paginate(12);
        $this->page['transfers'] = $transferModel->paginate(12);
        $this->page['totalSales'] = $rentals->count() + $transfers->count();
        $this->page['totalRentalOrders'] = $rentals->count();
        $this->page['totalTransfersOrders'] = $transfers->count();

    }

    public function onTransferPaginate()
    {
        //giriş yapan kullanıcıyı bulduk
        $user = Auth::getUser();

        $transferModel = Transfer::with(['transfer_invoice', 'car.brand', 'car.mdl', 'car.trim', 'car.year', 'user'])->where('confirm', '1')->where('seller_id', $user->id);
        $perPage = post('perPage');
        $pageNumber = $perPage;
        $this->page['partialsRecords'] = $transferModel->paginate(12, $pageNumber);

    }

    public function onRentalPaginate()
    {
        //giriş yapan kullanıcıyı bulduk
        $user = Auth::getUser();


        $rentalModel = Rental::with(['rental_invoice', 'car.brand', 'car.mdl', 'car.trim', 'car.year', 'user'])->where('confirm', '1')->where('seller_id', $user->id);
        $perPage = post('perPage');
        $pageNumber = $perPage;
        $this->page['partialsRecords'] = $rentalModel->paginate(12, $pageNumber);

    }


}
