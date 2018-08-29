<?php namespace Nemerki\Builder\Components;

use Lang;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use RainLab\Builder\Classes\ComponentHelper;
use SystemException;
use Exception;


class RecordList extends ComponentBase
{
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
            'name' => 'Record list',
            'description' => 'Seçilen model için kayıt listesini görüntüler'
        ];
    }

    //
    // Properties
    //

    public function defineProperties()
    {
        return [
            'modelClass' => [
                'title' => 'rainlab.builder::lang.components.list_model',
                'type' => 'dropdown',
                'showExternalParam' => false
            ],
            'scope' => [
                'title' => 'rainlab.builder::lang.components.list_scope',
                'description' => 'rainlab.builder::lang.components.list_scope_description',
                'type' => 'dropdown',
                'depends' => ['modelClass'],
                'showExternalParam' => false
            ],
            'scopeValue' => [
                'title' => 'rainlab.builder::lang.components.list_scope_value',
                'description' => 'rainlab.builder::lang.components.list_scope_value_description',
                'type' => 'string',
                'default' => '{{ :scope }}',
            ],
            'displayColumn' => [
                'title' => 'rainlab.builder::lang.components.list_display_column',
                'description' => 'rainlab.builder::lang.components.list_display_column_description',
                'type' => 'autocomplete',
                'depends' => ['modelClass'],
                'validation' => [
                    'required' => [
                        'message' => Lang::get('rainlab.builder::lang.components.list_display_column_required')
                    ]
                ]
            ],
            'noRecordsMessage' => [
                'title' => 'rainlab.builder::lang.components.list_no_records',
                'description' => 'rainlab.builder::lang.components.list_no_records_description',
                'type' => 'string',
                'default' => Lang::get('rainlab.builder::lang.components.list_no_records_default'),
                'showExternalParam' => false,
            ],
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
            'sortColumn' => [
                'title' => 'rainlab.builder::lang.components.list_sort_column',
                'description' => 'rainlab.builder::lang.components.list_sort_column_description',
                'type' => 'autocomplete',
                'depends' => ['modelClass'],
                'group' => 'rainlab.builder::lang.components.list_sorting',
                'showExternalParam' => false
            ],
            'sortDirection' => [
                'title' => 'rainlab.builder::lang.components.list_sort_direction',
                'type' => 'dropdown',
                'showExternalParam' => false,
                'group' => 'rainlab.builder::lang.components.list_sorting',
                'options' => [
                    'asc' => 'rainlab.builder::lang.components.list_order_direction_asc',
                    'desc' => 'rainlab.builder::lang.components.list_order_direction_desc'
                ]
            ],
            'whereIsActive' => [
                'title' => 'whereIsActive',
                'description' => 'is_active elave et',
                'type' => 'dropdown',
                'showExternalParam' => false,
                'group' => 'Where',
                'options' => [
                    '1' => 'yes',
                    '0' => 'no',
                ]
            ],
            'whereColumn' => [
                'title' => 'Where column',
                'description' => 'where koşulu eklenecek sütun adı',
                'type' => 'autocomplete',
                'depends' => ['modelClass'],
                'group' => 'Where',
                'showExternalParam' => false
            ],
            'whereOperator' => [
                'title' => 'Where Operator',
                'description' => 'Oparator seç',
                'type' => 'dropdown',
                'showExternalParam' => false,
                'group' => 'Where',
                'options' => [
                    '=' => '=',
                    '<' => '<',
                    '<=' => '<=',
                    '>' => '>',
                    '>=' => '>=',
                    '<>' => '<>',

                ]
            ],
            'whereKey' => [
                'title' => 'Where Key',
                'description' => 'where koşulu değeri',
                'type' => 'string',
                'validationPattern' => '^[a-zA-Z0-9]*$',
                'validationMessage' => 'Wherekey alanı Sadece reqem yada herf ola biler',
                'group' => 'Where',
            ],
            'whereColumn2' => [
                'title' => 'Where column2',
                'description' => 'where koşulu eklenecek sütun adı',
                'type' => 'autocomplete',
                'depends' => ['modelClass'],
                'group' => 'Where',
                'showExternalParam' => false
            ],
            'whereOperator2' => [
                'title' => 'Where Operator2',
                'description' => 'Oparator seç',
                'type' => 'dropdown',
                'showExternalParam' => false,
                'group' => 'Where',
                'options' => [
                    '=' => '=',
                    '<' => '<',
                    '<=' => '<=',
                    '>' => '>',
                    '>=' => '>=',
                    '<>' => '<>',

                ]
            ],
            'whereKey2' => [
                'title' => 'Where Key2',
                'description' => 'where koşulu değeri',
                'type' => 'string',
                'validationPattern' => '^[a-zA-Z0-9]*$',
                'validationMessage' => 'Wherekey alanı Sadece reqem yada herf ola biler',
                'group' => 'Where',
            ],
            'whereColumn3' => [
                'title' => 'Where column3',
                'description' => 'where koşulu eklenecek sütun adı',
                'type' => 'autocomplete',
                'depends' => ['modelClass'],
                'group' => 'Where',
                'showExternalParam' => false
            ],
            'whereOperator3' => [
                'title' => 'Where Operator3',
                'description' => 'Oparator seç',
                'type' => 'dropdown',
                'showExternalParam' => false,
                'group' => 'Where',
                'options' => [
                    '=' => '=',
                    '<' => '<',
                    '<=' => '<=',
                    '>' => '>',
                    '>=' => '>=',
                    '<>' => '<>',

                ]
            ],
            'whereKey3' => [
                'title' => 'Where Key3',
                'description' => 'where koşulu değeri',
                'type' => 'string',
                'validationPattern' => '^[a-zA-Z0-9]*$',
                'validationMessage' => 'Wherekey alanı Sadece reqem yada herf ola biler',
                'group' => 'Where',
            ],
            'whereColumn4' => [
                'title' => 'Where column4',
                'description' => 'where koşulu eklenecek sütun adı',
                'type' => 'autocomplete',
                'depends' => ['modelClass'],
                'group' => 'Where',
                'showExternalParam' => false
            ],
            'whereOperator4' => [
                'title' => 'Where Operator4',
                'description' => 'Oparator seç',
                'type' => 'dropdown',
                'showExternalParam' => false,
                'group' => 'Where',
                'options' => [
                    '=' => '=',
                    '<' => '<',
                    '<=' => '<=',
                    '>' => '>',
                    '>=' => '>=',
                    '<>' => '<>',

                ]
            ],
            'whereKey4' => [
                'title' => 'Where Key4',
                'description' => 'where koşulu değeri',
                'type' => 'string',
                'validationPattern' => '^[a-zA-Z0-9]*$',
                'validationMessage' => 'Wherekey alanı Sadece reqem yada herf ola biler',
                'group' => 'Where',
            ],
            'take' => [
                'title' => 'Take',
                'description' => 'neçe kayıt çekilsin',
                'type' => 'string',
                'validationPattern' => '^[0-9]*$',
                'validationMessage' => 'Sadece reqem',
                'group' => 'take & skip',
            ],
            'skip' => [
                'title' => 'Skip',
                'description' => 'neçe kayıt atlansın',
                'type' => 'string',
                'validationPattern' => '^[0-9]*$',
                'validationMessage' => 'Sadece reqem',
                'group' => 'take & skip',
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

    public function getModelClassOptions()
    {
        return ComponentHelper::instance()->listGlobalModels();
    }

    public function getDisplayColumnOptions()
    {
        return ComponentHelper::instance()->listModelColumnNames();
    }

    public function getDetailsKeyColumnOptions()
    {
        return ComponentHelper::instance()->listModelColumnNames();
    }

    public function getSortColumnOptions()
    {
        return ComponentHelper::instance()->listModelColumnNames();
    }

    public function getwhereColumnOptions()
    {
        return ComponentHelper::instance()->listModelColumnNames();
    }

    public function getwhereColumn2Options()
    {
        return ComponentHelper::instance()->listModelColumnNames();
    }

    public function getwhereColumn3Options()
    {
        return ComponentHelper::instance()->listModelColumnNames();
    }

    public function getwhereColumn4Options()
    {
        return ComponentHelper::instance()->listModelColumnNames();
    }

    public function getwhereIsActiveOptions()
    {
        return ComponentHelper::instance()->listModelColumnNames();
    }

    public function getScopeOptions()
    {
        $modelClass = ComponentHelper::instance()->getModelClassDesignTime();

        $result = [
            '-' => Lang::get('rainlab.builder::lang.components.list_scope_default')
        ];
        try {
            $methods = get_class_methods($modelClass);

            foreach ($methods as $method) {
                if (preg_match('/scope[A-Z].*/', $method)) {
                    $result[$method] = $method;
                }
            }
        } catch (Exception $ex) {
            // Ignore invalid models
        }

        return $result;
    }

    //
    // Rendering and processing
    //

    public function onRun()
    {
        $this->prepareVars();

        $this->records = $this->page['records'] = $this->listRecords();
    }

    protected function prepareVars()
    {
        $this->noRecordsMessage = $this->page['noRecordsMessage'] = Lang::get($this->property('noRecordsMessage'));
        $this->displayColumn = $this->page['displayColumn'] = $this->property('displayColumn');
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');

        $this->detailsKeyColumn = $this->page['detailsKeyColumn'] = $this->property('detailsKeyColumn');
        $this->detailsUrlParameter = $this->page['detailsUrlParameter'] = $this->property('detailsUrlParameter');

        $detailsPage = $this->property('detailsPage');
        if ($detailsPage == '-') {
            $detailsPage = null;
        }

        $this->detailsPage = $this->page['detailsPage'] = $detailsPage;

        if (!strlen($this->displayColumn)) {
            throw new SystemException('The display column name is not set.');
        }

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
        $modelClassName = $this->property('modelClass');
        if (!strlen($modelClassName) || !class_exists($modelClassName)) {
            throw new SystemException('Invalid model class name');
        }

        $model = new $modelClassName();
        $scope = $this->getScopeName($model);
        $scopeValue = $this->property('scopeValue');

        if ($scope !== null) {
            $model = $model->$scope($scopeValue);
        }

        $model = $this->whereIsActive($model);
        $model = $this->where($model);
        $model = $this->where2($model);
        $model = $this->where3($model);
        $model = $this->where4($model);
        $model = $this->sort($model);
        $model = $this->take($model);
        $model = $this->skip($model);
        $records = $this->paginate($model);

        return $records;
    }

    protected function getScopeName($model)
    {
        $scopeMethod = trim($this->property('scope'));
        if (!strlen($scopeMethod) || $scopeMethod == '-') {
            return null;
        }

        if (!preg_match('/scope[A-Z].+/', $scopeMethod)) {
            throw new SystemException('Invalid scope method name.');
        }

        if (!method_exists($model, $scopeMethod)) {
            throw new SystemException('Scope method not found.');
        }

        return lcfirst(substr($scopeMethod, 5));
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

    protected function sort($model)
    {
        $sortColumn = trim($this->property('sortColumn'));
        if (!strlen($sortColumn)) {
            return $model;
        }

        $sortDirection = trim($this->property('sortDirection'));

        if ($sortDirection !== 'desc') {
            $sortDirection = 'asc';
        }

        // Note - no further validation of the sort column
        // value is performed here, relying to the ORM sanitizing.
        return $model->orderBy($sortColumn, $sortDirection);
    }

    protected function whereIsActive($model)
    {
        $whereIsActive = trim($this->property('whereIsActive'));
        if (!strlen($whereIsActive)) {
            return $model;
        }

        return $model->where('is_active', '1');
    }

    protected function where($model)
    {
        $whereColumn = trim($this->property('whereColumn'));
        if (!strlen($whereColumn)) {
            return $model;
        }

        $whereOperator = trim($this->property('whereOperator'));

        $whereKey = trim($this->property('whereKey'));


        // Note - no further validation of the sort column
        // value is performed here, relying to the ORM sanitizing.
        return $model->where($whereColumn, $whereOperator, $whereKey);
    }

    protected function where2($model)
    {
        $whereColumn2 = trim($this->property('whereColumn2'));
        if (!strlen($whereColumn2)) {
            return $model;
        }

        $whereOperator2 = trim($this->property('whereOperator2'));

        $whereKey2 = trim($this->property('whereKey2'));


        // Note - no further validation of the sort column
        // value is performed here, relying to the ORM sanitizing.
        return $model->where($whereColumn2, $whereOperator2, $whereKey2);
    }

    protected function where3($model)
    {
        $whereColumn3 = trim($this->property('whereColumn3'));
        if (!strlen($whereColumn3)) {
            return $model;
        }

        $whereOperator3 = trim($this->property('whereOperator3'));

        $whereKey3 = trim($this->property('whereKey3'));


        // Note - no further validation of the sort column
        // value is performed here, relying to the ORM sanitizing.
        return $model->where($whereColumn3, $whereOperator3, $whereKey3);
    }

    protected function where4($model)
    {
        $whereColumn4 = trim($this->property('whereColumn4'));
        if (!strlen($whereColumn4)) {
            return $model;
        }

        $whereOperator4 = trim($this->property('whereOperator4'));

        $whereKey4 = trim($this->property('whereKey4'));


        // Note - no further validation of the sort column
        // value is performed here, relying to the ORM sanitizing.
        return $model->where($whereColumn4, $whereOperator4, $whereKey4);
    }

    protected function take($model)
    {
        $take = trim($this->property('take'));
        if (!strlen($take)) {

            return $model;
        }

        if (!preg_match('/^[0-9]+$/', $take)) {
            throw new SystemException('Invalid records per page value.');
        }

        return $model->take($take);
    }

    protected function skip($model)
    {

        $skip = trim($this->property('skip'));
        if (!strlen($skip)) {

            return $model;
        }

        if (!preg_match('/^[0-9]+$/', $skip)) {
            throw new SystemException('Invalid records per page value.');
        }
        /*Skip ile paginate aynı anda kullanılmadığı için skip olduğu zaman önce modelden değerler çekilip take ile
         alıp lists ile id lerini götürürük
        whernot in ile de o değerler olmayanları seçirik kısaca hem skip hem paginate seçilirse aşağıdakı kod çalışır*/
        $recordsPerPage = trim($this->property('recordsPerPage'));
        if (strlen($recordsPerPage)) {
            $modelClassName = $this->property('modelClass');
            $sortColumn = trim($this->property('sortColumn'));
            $sortDirection = trim($this->property('sortDirection'));
            if ($sortDirection !== 'desc') {
                $sortDirection = 'asc';
            }

            $mod = $modelClassName::orderBy($sortColumn, $sortDirection)->take($skip)->get();
            $array = $mod->lists('id');

            return $model->whereNotIn('id', $array);
        }

        return $model->skip($skip);
    }

    public function onPaginate()
    {
        $this->prepareVars();
        $modelClassName = $this->property('modelClass');
        if (!strlen($modelClassName) || !class_exists($modelClassName)) {
            throw new SystemException('Invalid model class name');
        }

        $model = new $modelClassName();

        $model = $this->where($model);
        $model = $this->where2($model);
        $model = $this->where3($model);
        $model = $this->where4($model);
        $model = $this->sort($model);
        $model = $this->take($model);
        $model = $this->skip($model);
        $recordsPerPage = trim($this->property('recordsPerPage'));

        $perPage = post('perPage');
        $pageNumber = $perPage;


        $partialsRecords = $model->paginate($recordsPerPage, $pageNumber);

        $this->records = $this->page['partialsRecords'] = $partialsRecords;

    }

}

