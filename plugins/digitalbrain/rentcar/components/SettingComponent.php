<?php namespace DigitalBrain\RentCar\Components;

use Cms\Classes\ComponentBase;
use RainLab\User\Models\User;

class SettingComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Setting',
            'description' => 'Setting Page Component'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onSave()
    {
        $data = post();

        $user = User::where('id', post('user_id'))->first();

        $user->update($data);
    }
}
