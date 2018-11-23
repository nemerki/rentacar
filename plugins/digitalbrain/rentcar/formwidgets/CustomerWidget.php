<?php namespace Digitalbrain\Rentcar\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * CustomerWidget Form Widget
 */
class CustomerWidget extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'digitalbrain_rentcar_customer_widget';

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
        return $this->makePartial('customerwidget');
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
        $this->addCss('css/customerwidget.css', 'Digitalbrain.rentcar');
        $this->addJs('js/customerwidget.js', 'Digitalbrain.rentcar');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
