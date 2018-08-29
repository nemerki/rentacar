<?php namespace JorgeAndrade\SubscribePlus\Console;

use Mail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use JorgeAndrade\SubscribePlus\Models\Lists;
use JorgeAndrade\SubscribePlus\Models\Campaign;
use JorgeAndrade\SubscribePlus\Models\Message;
use JorgeAndrade\SubscribePlus\Models\Template;
use JorgeAndrade\SubscribePlus\Classes\TemplateTrait;
use JorgeAndrade\Subscribe\Components\Subscriber as SubscriberComponent;

class CampaignCommand extends Command
{
    use TemplateTrait;

    /**
     * @var string The console command name.
     */
    protected $name = 'subscribeplus:run';

    /**
     * @var string The console command description.
     */
    protected $description = 'Sent the campaigns.';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        // \Log::info("scheluded_every: {$scheluded_every}");
        $campaigns = $this->getCampaigns($this->argument('scheluded_every'));
        foreach ($campaigns as $campaign) {
            $this->parseDelay($campaign);
            if (in_array($campaign->scheluded_every, ['daily', 'weekly', 'monthly'])) {
                $campaign->status = 3;
                $campaign->save();
            }
            foreach ($campaign->list->subscribers as $subscriber) {
                $message = Message::create([
                    'subscriber_id' => $subscriber->id,
                    'subject' => $campaign->subject,
                    'html' => $campaign->html,
                    'campaign_id' => $campaign->id,
                ]);

                $htmlBody = $this->parseHtml($campaign, $message, $subscriber);
                $message->html = $htmlBody;
                $message->save();

                $htmlBody .= $this->setImgUrl($message);

                Mail::send([
                    'html' => $htmlBody,
                    'raw' => true
                ], [], function ($m) use($subscriber, $campaign) {
                    $m->from($campaign->list->default_email, $campaign->list->default_name);
                    $m->subject($campaign->subject);
                    $m->to($subscriber->email, "{$subscriber->name} {$subscriber->surname}");
                });

                if ( count( Mail::failures() ) ) {
                    $message->is_bounce = 1;
                    $message->save();
                    \Log::error("Email has not been send to: {$subscriber->email}");
                    \Log::error(Mail::failures());
                    continue;
                }

                \Log::info("Email has send to: {$subscriber->email}");
            }

            $campaign->status = 4;
            $campaign->save();
        }

        $this->output->writeln("Campaigns was successfully sent");
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['scheluded_every', InputArgument::OPTIONAL, 'Each when the script runs', 0],
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    protected function getCampaigns($scheluded_every)
    {
        $scheluded_every = (string) $scheluded_every;
        if (in_array($scheluded_every, ['daily', 'weekly', 'monthly'])) {
            return Campaign::where('scheluded_every', $scheluded_every)->whereNotIn('status', [1, 5, 6])->get();
        }

        if ($scheluded_every == '0') {
            return Campaign::where('is_delay', 0)->whereIn('status', [2, 3])->get();
        }

        return Campaign::where('is_delay', 1)->whereIn('status', [2, 3])->get();
    }

    protected function parseDelay($campaign)
    {
        if ($campaign->is_delay) {
            if ($campaign->delayed_at > Carbon::now()->format('Y-m-d H:i:s')) {
                return false;
            }
        }
    }

    public function handle()
    {
        $this->fire();
    }

}