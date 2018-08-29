<?php namespace DigitalBrain\RentCar\Components;

use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use DigitalBrain\RentCar\Models\Ban;
use DigitalBrain\RentCar\Models\Brand;
use DigitalBrain\RentCar\Models\Car;
use DigitalBrain\RentCar\Models\City;
use DigitalBrain\RentCar\Models\Color;
use DigitalBrain\RentCar\Models\EngineVolume;
use DigitalBrain\RentCar\Models\EquipmentCategory;
use DigitalBrain\RentCar\Models\Fuel;
use DigitalBrain\RentCar\Models\Models;
use DigitalBrain\RentCar\Models\RentalValue;
use DigitalBrain\RentCar\Models\Seat;
use DigitalBrain\RentCar\Models\Transmision;
use DigitalBrain\RentCar\Models\Wheel;
use DigitalBrain\RentCar\Models\Year;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;


use Lang;
use Cms\Classes\Page;
use RainLab\Builder\Classes\ComponentHelper;
use SystemException;
use Exception;


class RentCatalogComponent extends ComponentBase
{
    public $brand_id;
    public $paginationVariable;


    /**
     * A collection of records to display
     * @var \October\Rain\Database\Collection
     */
    public $records;

    /**
     * Message to display when there are no records.
     * @var string
     */
    public $noRecordsMessage;

    /**
     * Reference to the page name for linking to details.
     * @var string
     */
    public $detailsPage;

    /**
     * Specifies the current page number.
     * @var integer
     */
    public $pageNumber;

    /**
     * Parameter to use for the page number
     * @var string
     */
    public $pageParam;

    /**
     * Model column name to display in the list.
     * @var string
     */
    public $displayColumn;

    /**
     * Model column to use as a record identifier in the details page links
     * @var string
     */
    public $detailsKeyColumn;

    /**
     * Name of the details page URL parameter which takes the record identifier.
     * @var string
     */
    public $detailsUrlParameter;

    public function componentDetails()
    {
        return [
            'name' => 'RentCatalogComponent',
            'description' => 'Rent Catalog Page Component'
        ];
    }

    public function defineProperties()
    {
        return [
            'detailsPage' => [
                'title' => 'rainlab.builder::lang.components.list_details_page',
                'description' => 'rainlab.builder::lang.components.list_details_page_description',
                'type' => 'dropdown',
                'showExternalParam' => false,
                'group' => 'rainlab.builder::lang.components.list_details_page_link'
            ],
            'detailsKeyColumn' => [
                'title' => 'rainlab.builder::lang.components.list_details_key_column',
                'description' => 'rainlab.builder::lang.components.list_details_key_column_description',
                'type' => 'autocomplete',
                'depends' => ['modelClass'],
                'showExternalParam' => false,
                'group' => 'rainlab.builder::lang.components.list_details_page_link'
            ],
            'detailsUrlParameter' => [
                'title' => 'rainlab.builder::lang.components.list_details_url_parameter',
                'description' => 'rainlab.builder::lang.components.list_details_url_parameter_description',
                'type' => 'string',
                'default' => 'id',
                'showExternalParam' => false,
                'group' => 'rainlab.builder::lang.components.list_details_page_link'
            ],
        ];
    }

    public function onRun()
    {
        $this->page['price'] = $this->listPrice();
        $this->page['brands'] = $this->listBrand();
        $this->page['years'] = $this->listYear();
        $this->page['fuels'] = $this->listFuel();
        $this->page['transmisions'] = $this->listTransmision();
        $this->page['wheels'] = $this->listWheel();
        $this->page['engine_volumes'] = $this->listEngineVolume();
        $this->page['bans'] = $this->listBan();
        $this->page['colors'] = $this->listColor();
        $this->page['seats'] = $this->listSeat();
        $this->page['equipmentCategories'] = $this->listEquipmentCategory();
        $this->page['cities'] = $this->listCity();

    }


    protected function listSeat()
    {
        $model = new Seat();
        return $model->orderBy('number', 'ASC')->get();
    }

    protected function listEquipmentCategory()
    {
        $model = new EquipmentCategory();
        return $model->orderBy('sort_order', 'ASC')->get();
    }

    protected function listBan()
    {
        $model = new Ban();
        return $model->orderBy('name', 'ASC')->get();
    }

    protected function listColor()
    {
        $model = new Color();
        return $model->orderBy('name', 'ASC')->get();
    }

    protected function listFuel()
    {
        $model = Fuel::all();
        return $model;
    }

    protected function listTransmision()
    {
        $model = Transmision::all();
        return $model;
    }

    protected function listWheel()
    {
        $model = Wheel::all();
        return $model;
    }

    protected function listEngineVolume()
    {
        $model = EngineVolume::all();
        $this->page['volumeMax'] = $model->max('volume');
        $this->page['volumeMin'] = $model->min('volume');
        return $model;
    }

    protected function listPrice()
    {
        $model = new RentalValue();
        $this->page['priceMax'] = $model->max('one_day');
        $this->page['priceMin'] = $model->min('one_day');
    }

    protected function listCity()
    {
        $model = new City();
        return $model->orderBy('sort_order', 'ASC')->get();
    }

    protected function listYear()
    {
        $model = Year::orderBy('year', 'ASC')->get();
        $this->page['yearsMax'] = $model->max('year');
        $this->page['yearsMin'] = $model->min('year');
        return $model;
    }

    protected function listBrand()
    {
        $model = new Brand();
        return $model->orderBy('name', 'ASC')->get();
    }

    public function onModel()
    {
        $this->brand_id = $brand_id = post('brand_id');
        $model = Brand::where('id', $brand_id)->first();
        $this->page['models'] = $model->mdls;
//        $car = Car::where('brand_id', $brand_id)->where('is_active', '1')->paginate(1);
//        $this->page['partialsRecords'] = $car;
//        $this->page['filterClass'] = 'filterAjaxPagination';
    }


    public function onSearch()
    {
        $this->prepareVars();
        $model = Car::with(['location', 'rental_value', 'engine_volume', 'year']);
        $model = $model->where('confirm', '1')->where('is_published', '1')->where('is_rent', '1');

        $ids = ['brand_id', 'mdl_id', 'fuel_id', 'ban_id', 'color_id', 'seat_id', 'transmision_id', 'wheel_id'];
        $data = post();
        foreach ($data as $key => $value) {

            if (in_array($key, $ids)) {
                $model = $model->where($key, $value);
            }

        }
//
        if (post('city_id')) {
            $city_id = post('city_id');
            $model = $model->whereHas('location', function ($q) use ($city_id) {
                $q->where('city_id', $city_id);
            });
        }

        $year_min = post('year_min');
        $year_max = post('year_max');
        $model = $model->whereHas('year', function ($q) use ($year_min, $year_max) {
            $q->where('year', '>=', $year_min)->where('year', '<=', $year_max);
        });

        $engine_volume_min = post('engine_volume_min');
        $engine_volume_max = post('engine_volume_max');
        $model = $model->whereHas('engine_volume', function ($q) use ($engine_volume_min, $engine_volume_max) {
            $q->where('volume', '>=', $engine_volume_min)->where('volume', '<=', $engine_volume_max);
        });


        $price_min = post('price_min');
        $price_max = post('price_max');
        $model = $model->whereHas('rental_value', function ($q) use ($price_min, $price_max) {
            $q->where('one_day', '>=', $price_min)->where('one_day', '<=', $price_max);
        });


        $model = $model->paginate(12);
        $this->page['partialsRecords'] = $model;
        $this->page['filterResultPagination'] = $model;
        $this->page['filterClass'] = 'filterAjaxPagination';
    }

    public function onFilterResultPagination()
    {
        $this->prepareVars();
        $model = Car::with(['location', 'rental_value', 'engine_volume', 'year']);
        $model = $model->where('confirm', '1')->where('is_published', '1')->where('is_rent', '1');
        $ids = ['brand_id', 'mdl_id', 'fuel_id', 'ban_id', 'color_id', 'seat_id', 'transmision_id', 'wheel_id'];
        $data = post();

        foreach ($data as $key => $value) {

            if (in_array($key, $ids)) {
                $model = $model->where($key, $value);
            }

        }
//
        if (post('city_id')) {
            $city_id = post('city_id');
            $model = $model->whereHas('location', function ($q) use ($city_id) {
                $q->where('city_id', $city_id);
            });
        }

        $year_min = post('year_min');
        $year_max = post('year_max');
        $model = $model->whereHas('year', function ($q) use ($year_min, $year_max) {
            $q->where('year', '>=', $year_min)->where('year', '<=', $year_max);
        });

        $engine_volume_min = post('engine_volume_min');
        $engine_volume_max = post('engine_volume_max');
        $model = $model->whereHas('engine_volume', function ($q) use ($engine_volume_min, $engine_volume_max) {
            $q->where('volume', '>=', $engine_volume_min)->where('volume', '<=', $engine_volume_max);
        });


        $price_min = post('price_min');
        $price_max = post('price_max');
        $model = $model->whereHas('rental_value', function ($q) use ($price_min, $price_max) {
            $q->where('one_day', '>=', $price_min)->where('one_day', '<=', $price_max);
        });


        $perPage = post('perPage');
        $pageNumber = $perPage;
        $model = $model->paginate(12, $pageNumber);

        $this->page['partialsRecords'] = $model;
        $this->page['filterResultPagination'] = $model;
        $this->page['filterClass'] = 'filterAjaxPagination';

    }

    protected function prepareVars()
    {
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');

        $this->detailsKeyColumn = $this->page['detailsKeyColumn'] = $this->property('detailsKeyColumn');
        $this->detailsUrlParameter = $this->page['detailsUrlParameter'] = $this->property('detailsUrlParameter');

        $detailsPage = $this->property('detailsPage');
        if ($detailsPage == '-') {
            $detailsPage = null;
        }

        $this->detailsPage = $this->page['detailsPage'] = $detailsPage;

        if (strlen($this->detailsPage)) {
            if (!strlen($this->detailsKeyColumn)) {
                throw new SystemException('The details key column should be set to generate links to the details page.');
            }

            if (!strlen($this->detailsUrlParameter)) {
                throw new SystemException('The details page URL parameter name should be set to generate links to the details page.');
            }
        }
    }

    public function getDetailsPageOptions()
    {
        $pages = Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');

        $pages = [
                '-' => Lang::get('rainlab.builder::lang.components.list_details_page_no')
            ] + $pages;

        return $pages;
    }


    public function getDetailsKeyColumnOptions()
    {
        return ComponentHelper::instance()->listModelColumnNames();
    }
}
