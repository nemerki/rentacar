<?php namespace DigitalBrain\RentCar\Components;

use Carbon\Carbon;
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


        $date = Carbon::now()->format('d.m.Y');


        if (Cache::has('usd')) {

            $this->page['usd'] = Cache::get('usd');
        } else {
            $connect_web = simplexml_load_file('https://www.cbar.az/currencies/' . $date . '.xml');
            $usd = $connect_web->ValType[1]->Valute[0]->Value->__toString();
            $this->page['usd'] = $usd;


            Cache::add('usd', $usd, 86400);
        }

    }
}
