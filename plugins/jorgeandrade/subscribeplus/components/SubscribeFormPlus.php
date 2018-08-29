<?php namespace JorgeAndrade\SubscribePlus\Components;

use Cms\Classes\ComponentBase;
use Str;
use URL;
use JorgeAndrade\SubscribePlus\Models\Lists;
use JorgeAndrade\Subscribe\Models\Subscriber as Subs;

class SubscribeFormPlus extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'SubscribeFormPlus Component',
            'description' => 'Form for subscribe in newsletters lists'
        ];
    }

    public function defineProperties()
    {
        return [
            'urlToUnsubscribe' => [
                'title'       => 'Url Unsubscribe',
                'description' => 'Path for generate a url to unsubscribe method',
                'type' => 'string',
                'default'     => 'unsubscribe'
            ],
            'urlToProfile' => [
                'title'       => 'Url Profile',
                'description' => 'Path for generate a url to profile form',
                'type' => 'string',
                'default'     => 'subscriber-profile'
            ],
            'geo' => [
                'title'       => 'Geolocation',
                'description' => 'Enable or disable geolocation',
                'type' => 'dropdown',
                'default'     => 'enabled'
            ],
            'thanksMessage' => [
                'title'       => 'Thanks Message',
                'description' => 'Thanks message for new subscribers',
                'type' => 'string',
                'default'     => 'Thanks for subscribe!'
            ],
            'errorMessage' => [
                'title'       => 'Error Message',
                'description' => 'Message for error thown',
                'type' => 'string',
                'default'     => 'Email already exists!'
            ]
        ];
    }

    public function getGeoOptions()
    {
        return ['enabled'=>'Enabled', 'disabled'=>'Disabled'];
    }

    public function onRun()
    {
        if ($this->property('geo') === 'enabled') {
            $this->addJs('/plugins/jorgeandrade/subscribe/assets/javascript/subscribe-scripts.js');
        }else{
            $this->addJs('/plugins/jorgeandrade/subscribe/assets/javascript/subscribe-scripts-no-geo.js');
        }
    }

    public function lists()
    {
        return Lists::all();
    }

    public function onAddSubscriber()
    {
        $data = [
            "email" => post('email'),
            "name" => post('name'),
            "surname" => post('surname'),
            "country" => post('country'),
            "latitude" => post('latitude'),
            "longitude" => post('longitude'),
            "code" => Str::random(20)
        ];
        
        try{

            $subscriber = Subs::create($data);
            $subscriber->lists()->attach(post('list_id'));
            $data['url'] = URL::to($this->property('urlToUnsubscribe')."/".$data['code']);
            $data['profile'] = URL::to($this->property('urlToProfile')."/".$data['code']);
            \Mail::send('jorgeandrade.subscribe::mail.subscribe', $data, function($message) use ($data) {
                $message->to($data['email'], $data['name'].' '.$data['surname']);
            });

            $this->page['result'] = $this->property('thanksMessage');
        }
        catch (\Exception $e){

            $this->page['result'] = $this->property('errorMessage');

        }
        
    }

}