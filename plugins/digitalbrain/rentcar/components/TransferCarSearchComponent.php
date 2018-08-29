<?php namespace DigitalBrain\RentCar\Components;

use Cms\Classes\ComponentBase;
use DigitalBrain\RentCar\Models\Car;
use Illuminate\Support\Facades\Session;
use Lang;
use Cms\Classes\Page;
use RainLab\Builder\Classes\ComponentHelper;
use SystemException;

use DigitalBrain\RentCar\Models\Ban;
use DigitalBrain\RentCar\Models\Brand;
use DigitalBrain\RentCar\Models\City;
use DigitalBrain\RentCar\Models\Color;
use DigitalBrain\RentCar\Models\EngineVolume;
use DigitalBrain\RentCar\Models\EquipmentCategory;
use DigitalBrain\RentCar\Models\Fuel;
use DigitalBrain\RentCar\Models\Seat;
use DigitalBrain\RentCar\Models\TransferValue;
use DigitalBrain\RentCar\Models\Transmision;
use DigitalBrain\RentCar\Models\Wheel;
use DigitalBrain\RentCar\Models\Year;


class TransferCarSearchComponent extends ComponentBase
{

    public $ban_id;
    public $brand_id;
    public $mdl_id;
    public $price;
    public $city_id;

    /**
     * A collection of records to display
     * @var \October\Rain\Database\Collection
     */
    public $records;


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
            'name' => 'TransferCarSearch',
            'description' => 'Transfer Car Search Page Component'
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
            'recordsPerPage' => [
                'title' => 'rainlab.builder::lang.components.list_records_per_page',
                'description' => 'rainlab.builder::lang.components.list_records_per_page_description',
                'type' => 'string',
                'validationPattern' => '^[0-9]*$',
                'validationMessage' => 'rainlab.builder::lang.components.list_records_per_page_validation',
                'group' => 'rainlab.builder::lang.components.list_pagination'
            ],
            'pageNumber' => [
                'title' => 'rainlab.builder::lang.components.list_page_number',
                'description' => 'rainlab.builder::lang.components.list_page_number_description',
                'type' => 'string',
                'default' => '{{ :page }}',
                'group' => 'rainlab.builder::lang.components.list_pagination'
            ],
        ];
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

    public function onRun()
    {

        $this->prepareVars();

        $this->records = $this->page['records'] = $this->listRecords();
        $this->page['searchClass'] = 'searchAjaxPagination';


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
        $model = new TransferValue();
        $this->page['priceMax'] = $model->max('city');
        $this->page['priceMin'] = $model->min('city');
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


    protected function listRecords()
    {


        if (Session::get('homeFilter') == "1") {
            $this->ban_id = $ban_id = Session::get('ban_id');
            $this->brand_id = $brand_id = Session::get('brand_id');
            $this->mdl_id = $mdl_id = Session::get('mdl_id');
            $this->price = $price = Session::get('price');
            $this->city_id = $city_id = Session::get('city_id');

            $model = Car::with(['location', 'rental_value', 'engine_volume', 'year']);
            $model = $model->where('confirm', "1")->where('is_published', '1')->where('is_transfer', '1')->orderBy('created_at','DESC');
            if ($ban_id) {
                $model = $model->where('ban_id', $ban_id);
            }

            if ($mdl_id) {
                $model = $model->where('mdl_id', $mdl_id);
            }
            if ($brand_id) {
                $model = $model->where('brand_id', $brand_id);
            }
            if ($price) {
                $model = $model->whereHas('transfer_value', function ($q) use ($price) {
                    $q->where('city', '<=', $price);
                });
            }

            if ($city_id) {
                $model = $model->whereHas('location', function ($q) use ($city_id) {
                    $q->where('city_id', $city_id);
                });
            }

            $records = $this->paginate($model);


            return $records;

        }


    }

    protected function paginate($model)
    {
        $recordsPerPage = trim($this->property('recordsPerPage'));
        if (!strlen($recordsPerPage)) {
            // Pagination is disabled - return all records
            return $model->get();
        }

        if (!preg_match('/^[0-9]+$/', $recordsPerPage)) {
            throw new SystemException('Invalid records per page value.');
        }

        $pageNumber = trim($this->property('pageNumber'));
        if (!strlen($pageNumber) || !preg_match('/^[0-9]+$/', $pageNumber)) {
            $pageNumber = 1;
        }

        return $model->paginate($recordsPerPage, $pageNumber);
    }


    public function onSearchPaginate()
    {

        $ban_id = $this->ban_id;
        $brand_id = $this->brand_id;
        $mdl_id = $this->mdl_id;
        $price = $this->price;
        $city_id = $this->city_id;


        $model = Car::with(['location', 'rental_value', 'engine_volume', 'year']);
        $model = $model->where('confirm', "1")->where('is_published', '1')->where('is_transfer', '1')->orderBy('created_at','DESC');
        if ($ban_id) {
            $model = $model->where('ban_id', $ban_id);
        }

        if ($mdl_id) {
            $model = $model->where('mdl_id', $mdl_id);
        }
        if ($brand_id) {
            $model = $model->where('brand_id', $brand_id);
        }
        if ($price) {
            $model = $model->whereHas('rental_value', function ($q) use ($price) {
                $q->where('one_day', '<=', $price);
            });
        }

        if ($city_id) {
            $model = $model->whereHas('location', function ($q) use ($city_id) {
                $q->where('city_id', $city_id);
            });
        }


        $recordsPerPage = trim($this->property('recordsPerPage'));

        $perPage = post('perPage');
        $pageNumber = $perPage;


        $partialsRecords = $model->paginate($recordsPerPage, $pageNumber);

        $this->records = $this->page['partialsRecords'] = $partialsRecords;
        $this->page['searchClass'] = 'searchAjaxPagination';
        $this->page['searchPainateClass'] = 'searchPainateClass';

    }

    public function onSearch()
    {
        $this->prepareVars();
        $model = Car::with(['location', 'transfer_value', 'engine_volume', 'year']);
        $model = $model->where('confirm', '1')->where('is_published', '1')->where('is_transfer', '1');

        $ids = ['brand_id', 'mdl_id', 'fuel_id', 'ban_id', 'color_id', 'seat_id', 'transmision_id', 'wheel_id'];
        $data = post();
        foreach ($data as $key => $value) {

            if (in_array($key, $ids)) {
                $model = $model->where($key, $value);
            }

        }
//        if (post('brand_id')) {
//            $model = $model->where('brand_id', post('brand_id'));
//        }
//        if (post('mdl_id')) {
//            $model = $model->where('mdl_id', post('mdl_id'));
//        }
//
//        if (post('fuel_id')) {
//            $model = $model->where('fuel_id', post('fuel_id'));
//        }
//        if (post('ban_id')) {
//            $model = $model->where('ban_id', post('ban_id'));
//        }
//        if (post('color_id')) {
//            $model = $model->where('color_id', post('color_id'));
//        }
//        if (post('seat_id')) {
//            $model = $model->where('seat_id', post('seat_id'));
//        }
//        if (post('transmision_id')) {
//            $model = $model->where('transmision_id', post('transmision_id'));
//        }
//        if (post('wheel_id')) {
//            $model = $model->where('wheel_id', post('wheel_id'));
//        }
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
        $model = $model->whereHas('transfer_value', function ($q) use ($price_min, $price_max) {
            $q->where('city', '>=', $price_min)->where('city', '<=', $price_max);
        });


        $model = $model->paginate(12);
        $this->page['partialsRecords'] = $model;
        $this->page['filterResultPagination'] = $model;
        $this->page['filterClass'] = 'filterAjaxPagination';
    }

    public function onFilterResultPagination()
    {
        $this->prepareVars();
        $model = Car::with(['location', 'transfer_value', 'engine_volume', 'year']);
        $model = $model->where('confirm', '1')->where('is_published', '1')->where('is_transfer', '1');
        $ids = ['brand_id', 'mdl_id', 'fuel_id', 'ban_id', 'color_id', 'seat_id', 'transmision_id', 'wheel_id'];
        $data = post();
        foreach ($data as $key => $value) {

            if (in_array($key, $ids)) {
                $model = $model->where($key, $value);
            }

        }
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
        $model = $model->whereHas('transfer_value', function ($q) use ($price_min, $price_max) {
            $q->where('city', '>=', $price_min)->where('city', '<=', $price_max);
        });
        $perPage = post('perPage');
        $pageNumber = $perPage;
        $model = $model->paginate(12, $pageNumber);

        $this->page['partialsRecords'] = $model;
        $this->page['filterResultPagination'] = $model;
        $this->page['filterClass'] = 'filterAjaxPagination';
    }

}
