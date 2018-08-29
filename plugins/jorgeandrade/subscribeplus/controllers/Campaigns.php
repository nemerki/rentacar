<?php namespace JorgeAndrade\SubscribePlus\Controllers;

use Artisan;
use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use JorgeAndrade\SubscribePlus\Classes\TemplateTrait;
use JorgeAndrade\SubscribePlus\Models\Campaign;
use JorgeAndrade\SubscribePlus\Models\Lists;
use JorgeAndrade\SubscribePlus\Models\Template;
use Mail;
use Redirect;
use Url;

/**
 * Campaigns Back-end Controller
 */
class Campaigns extends Controller
{
    use TemplateTrait;

    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('JorgeAndrade.SubscribePlus', 'subscribeplus', 'campaigns');

        $this->addCss('/plugins/jorgeandrade/subscribeplus/assets/css/styles.css');
        $this->addJs('/plugins/jorgeandrade/subscribeplus/assets/js/createcampaign.js');

        $this->parseAction();
    }

    public function update($recordId = null, $context = null)
    {

        $this->asExtension('FormController')->update($recordId);
        $this->vars['campaign'] = Campaign::findOrFail($recordId);
    }

    public function launch($recordId = null, $context = null)
    {
        $this->addCss('/modules/backend/formwidgets/datepicker/assets/vendor/pikaday/css/pikaday.css');
        $this->addCss('/modules/backend/formwidgets/datepicker/assets/vendor/clockpicker/css/jquery-clockpicker.css');
        $this->addCss('/modules/backend/formwidgets/datepicker/assets/css/datepicker.css');
        $this->addJs('/modules/backend/formwidgets/datepicker/assets/js/build-min.js');

        $this->asExtension('FormController')->preview($recordId, 'launch');
        $this->vars['campaign'] = Campaign::findOrFail($recordId);
        $this->vars['lists'] = Lists::all();
    }

    public function onCreateCampaign()
    {
        $this->asExtension('FormController')->create();
        return $this->makePartial('create_campaign');
    }

    public function onStoreCampaign()
    {
        $template = Template::find($template_id = post('Campaign[template]'));
        $campaign = Campaign::create([
            "name" => post('Campaign[name]'),
            "subject" => post('Campaign[name]'),
            "html" => $template->html,
            "template_id" => $template_id,
        ]);

        \Flash::success('Campaign has been created succesfully');
        return \Redirect::to(Url::to("admin/jorgeandrade/subscribeplus/campaigns/preview/{$campaign->id}"));
    }

    public function onAddModule($id)
    {
        return [
            "module" => $this->vars['modules'][post('module')],
        ];
    }

    public function onUpdateLaunch($recordId)
    {
        $request = \Request::all();
        $list_id = isset($request['list_id']) ? $request['list_id'] : null;
        if (is_null($list_id)) {
            return \Flash::error('Please select a list.');
        }
        $campaign = Campaign::find($recordId);
        $campaign->list_id = $list_id;
        if (isset($request['is_delay'])) {
            $campaign->is_delay = $request['is_delay'];
            $delayed_at = $request['delayed_at'];
            $campaign->delayed_at = $delayed_at['date'] . ' ' . $delayed_at['time'] . ':00';
        }

        if (isset($request['is_schelud'])) {
            $campaign->is_schelud = $request['is_schelud'];
            $campaign->scheluded_every = $request['scheluded_every'];
        }

        $campaign->save();

        \Flash::success('The Campaign has been updated successfully');
        return \Backend::redirect("jorgeandrade/subscribeplus/campaigns/preview/{$campaign->id}");
    }

    public function onLaunch($recordId)
    {
        $request = \Request::all();
        $list_id = isset($request['list_id']) ? $request['list_id'] : null;
        if (is_null($list_id)) {
            return \Flash::error('Please select a list.');
        }
        $campaign = Campaign::find($recordId);
        $campaign->list_id = $list_id;
        if (isset($request['is_delay'])) {
            $campaign->is_delay = $request['is_delay'];
            $delayed_at = $request['delayed_at'];
            $campaign->delayed_at = $delayed_at['date'] . ' ' . $delayed_at['time'] . ':00';
        }

        if (isset($request['is_schelud'])) {
            $campaign->is_schelud = $request['is_schelud'];
            $campaign->scheluded_every = $request['scheluded_every'];
        }

        $campaign->status = $this->getStatus($campaign);
        $campaign->is_launch = 1;
        $campaign->launched_at = \Carbon\Carbon::now();
        $campaign->save();

        Artisan::call('subscribeplus:run');

        \Flash::success('The Campaign has been launch successfully');
        return \Backend::redirect("jorgeandrade/subscribeplus/campaigns/preview/{$campaign->id}");
    }

    protected function getStatus($campaign)
    {
        if ($campaign->is_delay) {
            return 2;
        }

        return 3;
    }

    public function onUpdate($recordId)
    {
        $request = \Request::all();
        $request = $request['Campaign'];
        $campaign = Campaign::find($recordId);
        $html = $this->getHeader($campaign->template->code);
        $html .= $request['html'];
        $html .= $this->getFooter($campaign->template->code);
        $campaign->subject = $request['subject'];
        $campaign->html = $html;
        $campaign->save();

        \Flash::success('The Campaign has been updated successfully');
        return \Backend::redirect("jorgeandrade/subscribeplus/campaigns/update/{$campaign->id}");
    }

    public function onEditContent()
    {
        $type = post('type');
        $id = post('id');
        $text = post('text');
        $this->prepareVars([
            "id" => $id,
            "type" => $type,
            "text" => $text,
        ]);
        $partial = "{$type}_content";
        return $this->makePartial($partial);
    }

    public function prepareVars($vars)
    {
        foreach ($vars as $type => $value) {
            $this->vars[$type] = $value;
        }
    }

    public function onSendTestMessage($recordId)
    {
        $campaign = Campaign::find($recordId);
        $data = [];
        $user = $this->user;
        $html = $campaign->html;
        Mail::send([
            'html' => $html,
            'raw' => true,
        ], $data, function ($m) use ($user, $campaign) {
            $m->to($user->email, "{$user->first_name} {$user->last_name}");
            $m->subject($campaign->subject);
        });
        return Flash::success('The test message has been send successfully.');
    }

    public function onDeleteCampaign($recordId)
    {
        $campaign = Campaign::find($recordId);
        $campaign->status = 5;
        $campaign->save();
        Flash::success('The campaign has been delete successfully.');
        return Redirect::to('/admin/jorgeandrade/subscribeplus/campaigns/preview/' . $campaign->id);
    }

}
