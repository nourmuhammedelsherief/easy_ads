<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Restaurant\Azmak\AZOrder;
use App\Models\AzmakSetting;

class OrderPeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:period';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check order periods and terminate the finished orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = today()->format('Y-m-d');
        $setting = AzmakSetting::first();
        $orders = AZOrder::whereStatus('active')->get();
        if ($orders->count() > 0)
        {
            foreach ($orders as $order)
            {
                if ($order->created_at->addDays($setting->order_finished_days) < $today)
                {
                    $order->update([
                        'status'   => 'finished',
                    ]);
                }
            }
        }
    }
}
