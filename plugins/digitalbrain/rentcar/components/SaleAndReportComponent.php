<?php namespace DigitalBrain\RentCar\Components;

use Cms\Classes\ComponentBase;
use DigitalBrain\RentCar\Models\Car;
use DigitalBrain\RentCar\Models\Rental;
use DigitalBrain\RentCar\Models\Transfer;
use Lang;
use RainLab\User\Facades\Auth;
use SystemException;

class SaleAndReportComponent extends ComponentBase
{


    public function componentDetails()
    {
        return [
            'name' => 'SaleAndReport',
            'description' => 'Sale And Report Page Component'
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

        $rentalModel = Rental::with(['rental_invoice', 'car.brand', 'car.mdl', 'car.trim', 'car.year', 'user'])->where('confirm', '1')->where('seller_id', $user->id);
        $transferModel = Transfer::with(['transfer_invoice', 'car.brand', 'car.mdl', 'car.trim', 'car.year', 'user'])->where('confirm', '1')->where('seller_id', $user->id);

        $rentals = $rentalModel->get();
        $transfers = $transferModel->get();

        $this->page['rentals'] = $rentalModel->paginate(12);
        $this->page['transfers'] = $transferModel->paginate(12);
        $this->page['totalSales'] = $rentals->count() + $transfers->count();
        $this->page['totalRentalSales'] = $rentals->count();
        $this->page['totalTransfersSales'] = $transfers->count();

        //kullanıcıya aid toplam car sayısını bulmak için
        $cars = Car::where('user_id', $user->id)->get();
        $this->page['cars'] = $cars;

        //kullanıcının maşın kiralamasından kazandığı toplam para
        $rent_totla = [];
        foreach ($rentals as $rental) {
            $rent_totla[] = $rental->rental_invoice->total_amount_payable;
        }
        $rent_totla = array_sum($rent_totla);

        //kullanıcının maşın transferinden kazandığı toplam para
        $transfer_totla = [];
        foreach ($transfers as $transfer) {
            $transfer_totla[] = $transfer->transfer_invoice->total_amount_payable;
        }
        $transfer_totla = array_sum($transfer_totla);

        //kullanıcını hem rent hem transferden kazandığı paranın toplamı
        $totla_sale_amount = $rent_totla + $transfer_totla;
        $this->page['totla_sale_amount'] = $totla_sale_amount;
    }

    public function onTransferPaginate()
    {
        //giriş yapan kullanıcıyı bulduk
        $user = Auth::getUser();

        $transferModel = Transfer::with(['transfer_invoice', 'car.brand', 'car.mdl', 'car.trim', 'car.year', 'user'])->where('confirm', '1')->where('seller_id', $user->id);
        $perPage = post('perPage');
        $pageNumber = $perPage;
        $this->page['partialsRecords'] = $transferModel->paginate(12,$pageNumber);

    }

    public function onRentalPaginate()
    {
        //giriş yapan kullanıcıyı bulduk
        $user = Auth::getUser();


        $rentalModel = Rental::with(['rental_invoice', 'car.brand', 'car.mdl', 'car.trim', 'car.year', 'user'])->where('confirm', '1')->where('seller_id', $user->id);
        $perPage = post('perPage');
        $pageNumber = $perPage;
        $this->page['partialsRecords'] = $rentalModel->paginate(12,$pageNumber);

    }


}
