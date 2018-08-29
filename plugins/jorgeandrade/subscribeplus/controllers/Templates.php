<?php namespace JorgeAndrade\SubscribePlus\Controllers;

use Url;
use BackendMenu;
use Backend\Classes\Controller;
use JorgeAndrade\SubscribePlus\Models\Template;
use JorgeAndrade\SubscribePlus\Classes\TemplateTrait;

/**
 * Templates Back-end Controller
 */
class Templates extends Controller
{
    use TemplateTrait;

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $bodyClass = 'compact-container';

    protected $assetsPath = '/plugins/jorgeandrade/subscribeplus/assets';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('JorgeAndrade.SubscribePlus', 'subscribeplus', 'templates');

        $this->addCss($this->assetsPath.'/css/styles.css');
        $this->addJs($this->assetsPath.'/js/andrademail.js');

        $this->parseAction();
    }
}