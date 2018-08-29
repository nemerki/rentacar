<?php namespace JorgeAndrade\SubscribePlus\Classes;

use Backend;
use JorgeAndrade\SubscribePlus\Models\Campaign;
use JorgeAndrade\SubscribePlus\Models\Template;
use JorgeAndrade\Subscribe\Components\Subscriber as SubscriberComponent;
use Url;

trait TemplateTrait
{
    protected $templatesPath = '/plugins/jorgeandrade/subscribeplus/templates';

    protected function getModules($code)
    {
        $templateInfo = $this->parseTemplate($code);
        return $templateInfo['modules'];
    }

    protected function getIcons($code)
    {
        $templateInfo = $this->parseTemplate($code);
        return $templateInfo['icons'];
    }

    protected function getHeader($code)
    {
        $templatePath = $this->templatesPath . "/{$code}";
        $header = file_get_contents(Url::asset($templatePath . '/header.txt'));
        return $header;
    }

    protected function getFooter($code)
    {
        $templatePath = $this->templatesPath . "/{$code}";
        $footer = file_get_contents(Url::asset($templatePath . '/footer.txt'));
        return $footer;
    }

    protected function parseTemplate($code)
    {
        $templatePath = $this->templatesPath . "/{$code}";
        $templateInfo = file_get_contents(Url::asset($templatePath . '/template.json'));
        return json_decode($templateInfo, true);
    }

    protected function parseAction()
    {
        if (in_array($this->action, ['index', 'launch'])) {
            return false;
        }

        $action = ucfirst($this->action);
        $method = "parse{$action}";

        return $this->$method();
    }

    protected function parseUpdate()
    {
        $this->addCss('/plugins/jorgeandrade/subscribeplus/assets/css/update.css');
        $this->addCss('/modules/cms/widgets/mediamanager/assets/css/mediamanager.css?v292');
        $this->addCss('/modules/backend/formwidgets/richeditor/assets/css/richeditor.css?v292');
        $this->addJs('/modules/cms/widgets/mediamanager/assets/js/mediamanager-global-min.js');
        $this->addJs('/modules/cms/widgets/mediamanager/assets/js/mediamanager-browser-min.js?v292');
        $this->addJs('/modules/backend/widgets/form/assets/js/october.form.js?v292');
        $this->addJs('/modules/backend/formwidgets/richeditor/assets/js/build-min.js?v292');
        $this->addJs('/plugins/jorgeandrade/subscribeplus/assets/js/andrademail.js');

        $template = Campaign::find($this->params[0])->template;
        $this->vars['modules'] = $this->getModules($template->code);
        $this->vars['icons'] = $this->getIcons($template->code);
    }

    protected function parsePreview()
    {
        $campaign = Campaign::find($this->params[0]);
        $this->vars['campaign'] = $campaign;
    }

    protected function parseHtml($campaign, $mail, $subscriber)
    {
        $html = $campaign->html;
        $template = $campaign->template;
        $list = $campaign->list;
        $subscribercomponent = new SubscriberComponent;
        $unsubscribeurl = Url::to($subscribercomponent->property('urlToUnsubscribe') . "/" . $subscriber->code);
        $unsubscribe_url = "<a href='{$unsubscribeurl}'>Unsubscribe</a>";
        $online_version = Url::route('webversion', [
            'id' => $mail->id,
            'hash' => $mail->hash,
        ]);
        $online_version = "<a href='{$online_version}'>View in browser</a>";
        $html = preg_replace("/{{unsubscribe_url}}/", $unsubscribe_url, $html);
        $html = preg_replace("/{{online_version}}/", $online_version, $html);
        $html = preg_replace("/{{subject}}/", $campaign->subject, $html);
        $html = preg_replace("/{{comments}}/", $list->comments, $html);
        $html = preg_replace("/{{contact_info}}/", $list->contact_info, $html);
        $html = preg_replace("/{{name}}/", $subscriber->name, $html);
        $html = preg_replace("/{{surname}}/", $subscriber->surname, $html);
        return $html;
    }

    protected function setImgUrl($mail)
    {
        $url = Backend::url('jorgeandrade/subscribeplus/image/image', [
            'id' => $mail->id,
            'hash' => $mail->hash . '.png',
        ]);
        $img = '<img src="' . $url . '" style="display:none;width:0;height:0;" />';
        return $img;
    }

}
