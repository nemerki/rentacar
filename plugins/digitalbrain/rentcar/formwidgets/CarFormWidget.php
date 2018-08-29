<?php namespace DigitalBrain\RentCar\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Backend\Classes\FormField;

/**
 * CarFormWidget Form Widget
 */
class CarFormWidget extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'digitalbrain_rentcar_car_form_widget';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('carformwidget');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/carformwidget.css', 'DigitalBrain.RentCar');
        $this->addCss('css/main.css', 'DigitalBrain.RentCar');
        $this->addCss('css/custom.css', 'DigitalBrain.RentCar');
        $this->addCss('css/responsive.css', 'DigitalBrain.RentCar');
        $this->addJs('js/carformwidget.js', 'DigitalBrain.RentCar');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return FormField::NO_SAVE_DATA;
    }
}
