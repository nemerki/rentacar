<?php namespace Nemerki\Builder;

use Backend;
use System\Classes\PluginBase;

/**
 * Builder Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Nemerki Builder',
            'description' => 'Oluşturulacak pluagin seçeneklerini görsel olarak seç ',
            'author'      => 'Nemerki',
            'icon'        => 'icon-wrench'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {

        return [
            'Nemerki\Builder\Components\RecordList' => 'RecordList',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'nemerki.builder.some_permission' => [
                'tab' => 'Builder',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'builder' => [
                'label'       => 'Builder',
                'url'         => Backend::url('nemerki/builder/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['nemerki.builder.*'],
                'order'       => 500,
            ],
        ];
    }
}
