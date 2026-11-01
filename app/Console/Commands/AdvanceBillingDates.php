<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;

class AdvanceBillingDates extends Command
{
    protected $signature = 'subscriptions:advance-dates';

    protected $description = 'Geser tanggal tagihan langganan yang sudah lewat ke periode berikutnya';

    public function handle(): int
    {
        $count = 0;

        Subscription::where('is_active', true)
            ->whereDate('next_billing_date', '<', today())
            ->each(function (Subscription $subscription) use (&$count) {
                if ($subscription->advanceBillingDate()) {
                    $count++;
                }
            });

        $this->info("{$count} langganan diperbarui.");

        return self::SUCCESS;
    }
}