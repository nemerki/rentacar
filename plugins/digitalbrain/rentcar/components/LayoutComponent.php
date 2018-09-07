<?php namespace DigitalBrain\RentCar\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Cache;

class LayoutComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Layout',
            'description' => 'Layout Component'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {


        if (Cache::has('usd')) {

            $this->page['usd'] = Cache::get('usd');
        } else {
            $connect_web = simplexml_load_file('https://www.cbar.az/other/xml-azn-rates/');
            $usd = $connect_web->ValType[1]->Valute[44]->Value->__toString();
            $this->page['usd'] = $usd;

            Cache::add('usd', $usd, 86400);
        }

    }
}
