<?php namespace DigitalBrain\RentCar\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class RentalController extends Controller
{
    public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController'];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'manage_rental'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('DigitalBrain.RentCar', 'main-menu-item3','side-menu-item2');
    }
}
