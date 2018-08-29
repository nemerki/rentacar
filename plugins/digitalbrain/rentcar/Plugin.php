<?php namespace DigitalBrain\RentCar;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name' => 'Rent a car',
            'description' => 'Seyfeler üçün olan componentler',
            'author' => 'Nemerki',
            'icon' => 'icon-wrench'
        ];
    }

    public function registerComponents()
    {

        return [
            'DigitalBrain\RentCar\Components\AddNewCarComponent' => 'AddNewCarComponent',
            'DigitalBrain\RentCar\Components\RentCatalogComponent' => 'RentCatalogComponent',
            'DigitalBrain\RentCar\Components\TransferCatalogComponent' => 'TransferCatalogComponent',
            'DigitalBrain\RentCar\Components\CarDetailComponent' => 'CarDetail',
            'DigitalBrain\RentCar\Components\RentReservationComponent' => 'RentReservation',
            'DigitalBrain\RentCar\Components\TransferReservationComponent' => 'TransferReservation',
            'DigitalBrain\RentCar\Components\SettingComponent' => 'Setting',
            'DigitalBrain\RentCar\Components\ProfileMyCarListingComponent' => 'ProfileMyCarListing',
            'DigitalBrain\RentCar\Components\CarEditComponent' => 'CarEdit',
            'DigitalBrain\RentCar\Components\HomepageComponent' => 'Homepage',
            'DigitalBrain\RentCar\Components\RentCarSearchComponent' => 'RentCarSearch',
            'DigitalBrain\RentCar\Components\TransferCarSearchComponent' => 'TransferCarSearch',
            'DigitalBrain\RentCar\Components\SaleAndReportComponent' => 'SaleAndReport',
            'DigitalBrain\RentCar\Components\ProfileMyOrderComponent' => 'ProfileMyOrder',
        ];
    }

    public function registerSettings()
    {
    }

    public function registerFormWidgets()
    {
        return [

            'DigitalBrain\RentCar\FormWidgets\RentalFormWidget' => [
                'label' => 'Rental Info',
                'code' => 'rental'
            ],
            'DigitalBrain\RentCar\FormWidgets\TransferFormWidget' => [
                'label' => 'Transfer Info',
                'code' => 'transfer'
            ],
            'DigitalBrain\RentCar\FormWidgets\CarFormWidget' => [
                'label' => 'My Car Confirmation',
                'code' => 'mycar'
            ],

        ];
    }

}
