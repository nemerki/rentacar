<?php namespace DigitalBrain\RentCar\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Backend\Classes\FormField;

/**
 * TransferFormWidget Form Widget
 */
class TransferFormWidget extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'digitalbrain_rentcar_transfer_form_widget';

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
        return $this->makePartial('transferformwidget');
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
        $this->addCss('css/transferformwidget.css', 'DigitalBrain.RentCar');
        $this->addJs('js/transferformwidget.js', 'DigitalBrain.RentCar');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return FormField::NO_SAVE_DATA;
    }
}
