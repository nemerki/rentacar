<?php namespace DigitalBrain\RentCar\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class BrandController extends Controller
{
    public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController', 'Backend\Behaviors\ReorderController'];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'manage_brand'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('DigitalBrain.RentCar', 'main-menu-item', 'side-menu-item');
    }
}
