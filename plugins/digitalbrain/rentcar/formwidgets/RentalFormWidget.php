<?php namespace DigitalBrain\RentCar\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Backend\Classes\FormField;

/**
 * RentalFormWidget Form Widget
 */
class RentalFormWidget extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'digitalbrain_rentcar_rental_form_widget';

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
        return $this->makePartial('rentalformwidget');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['car'] = $this->model->car()->withTrashed()->first();
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/rentalformwidget.css', 'DigitalBrain.RentCar');
        $this->addJs('js/rentalformwidget.js', 'DigitalBrain.RentCar');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return FormField::NO_SAVE_DATA;
    }
}
