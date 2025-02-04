<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\EasyAdsSubscription;


class AzmakSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easy_ads:subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check active subscriptions active or finished';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptions = EasyAdsSubscription::whereStatus('active')->get();
        if ($subscriptions->count() > 0)
        {
            foreach ($subscriptions as $subscription)
            {
                if ($subscription->end_at < Carbon::now())
                {
                    $subscription->update([
                        'status' => 'finished',
                        'payment' => 'false',
                    ]);
                }
            }
        }
    }
}
