<?php namespace JorgeAndrade\SubscribePlus;

use Event;
use System\Classes\PluginBase;
use JorgeAndrade\SubscribePlus\Models\Message;
use JorgeAndrade\Subscribe\Models\Subscriber;
use JorgeAndrade\Subscribe\Controllers\Subscribers as SubscribersController;

/**
 * SubscribePlus Plugin Information File
 */
class Plugin extends PluginBase
{

    public $require = ['JorgeAndrade.Subscribe'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'SubscribePlus',
            'description' => 'A Subscribe Form Plus, is an extension of Subcribe Form for October CMS',
            'author'      => 'Jorge Andrade',
            'icon'        => 'icon-rss',
            'homepage'    => 'http://andradedev.com'
        ];
    }

    public function registerComponents()
    {
        return [
            'JorgeAndrade\SubscribePlus\Components\SubscribeFormPlus'       => 'subscribeformplus',
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('jorgeandrade.campaigncommand', 'JorgeAndrade\SubscribePlus\Console\CampaignCommand');
    }

    public function registerSchedule($schedule)
    {
        $schedule->command('subscribeplus:run daily')->daily();
        $schedule->command('subscribeplus:run weekly')->weekly();
        $schedule->command('subscribeplus:run monthly')->monthly();
        $schedule->command('subscribeplus:run delay')->hourly();
    }

    public function registerPermissions()
    {
        return [
            'jorgeandrade.subscribeplus.lists' => [
                'tab' => 'Subscribers Lists',
                'label' => 'Access to list of subscribers'
            ],
            'jorgeandrade.subscribeplus.campaigns' => [
                'tab' => 'Campaigns',
                'label' => 'Access to campaigns'
            ],
            'jorgeandrade.subscribeplus.templates' => [
                'tab' => 'Email Templates',
                'label' => 'Access to email templates'
            ],
        ];
    }

    public function registerNavigation()
    {
        return [
            'subscribeplus' => [
                'sideMenu' => [
                    'subscribers' => [
                        'label'       => 'Subscribers',
                        'icon'        => 'icon-rss',
                        'url'         => \Backend::url('jorgeandrade/subscribe/subscribers'),
                        'permissions' => ['jorgeandrade.subscribe.access_subscribers'],
                    ],
                    'lists' => [
                        'label'       => 'Subscribers Lists',
                        'icon'        => 'icon-list',
                        'url'         => \Backend::url('jorgeandrade/subscribeplus/lists'),
                        'permissions' => ['jorgeandrade.subscribeplus.lists'],
                    ],
                    'campaigns' => [
                        'label'       => 'Campaigns',
                        'icon'        => 'icon-newspaper-o',
                        'url'         => \Backend::url('jorgeandrade/subscribeplus/campaigns'),
                        'permissions' => ['jorgeandrade.subscribeplus.campaigns'],
                    ],
                    'templates' => [
                        'label'       => 'Templates',
                        'icon'        => 'icon-file-code-o',
                        'url'         => \Backend::url('jorgeandrade/subscribeplus/templates'),
                        'permissions' => ['jorgeandrade.subscribeplus.templates'],
                    ]
                ]

            ]
        ];
    }

    public function boot()
    {
        Event::listen('backend.menu.extendItems', function($manager){
            $manager->addSideMenuItems('JorgeAndrade.Subscribe', 'subscribe', [
                'lists' => [
                    'label'       => 'Subscribers Lists',
                    'icon'        => 'icon-list',
                    'url'         => \Backend::url('jorgeandrade/subscribeplus/lists'),
                    'permissions' => ['jorgeandrade.subscribeplus.lists'],
                ],
                'campaigns' => [
                    'label'       => 'Campaigns',
                    'icon'        => 'icon-newspaper-o',
                    'url'         => \Backend::url('jorgeandrade/subscribeplus/campaigns'),
                    'permissions' => ['jorgeandrade.subscribeplus.campaigns'],
                ],
                'templates' => [
                    'label'       => 'Templates',
                    'icon'        => 'icon-file-code-o',
                    'url'         => \Backend::url('jorgeandrade/subscribeplus/templates'),
                    'permissions' => ['jorgeandrade.subscribeplus.templates'],
                ]
            ]);

        });
        
        SubscribersController::extendListColumns(function($list, $model){
            if (!$model instanceof Subscriber) return ;

            $list->addColumns([
                'lists' => [
                    "Label" => "Lists",
                    "relation" => "lists",
                    "select" => "name"
                ]
            ]);
        });

        Subscriber::extend(function ($model) {
            $model->belongsToMany = [
                'lists' => [
                    'JorgeAndrade\SubscribePlus\Models\Lists', 
                    'table' => 'jorgeandrade_subscribeplus_lists_subscribers'
                ]
            ];
        });

    }

}
