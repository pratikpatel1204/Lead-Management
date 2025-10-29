<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExpireRewardPoints extends Command
{
    protected $signature = 'rewards:expire';
    protected $description = 'Expire reward points for customers';

    public function handle()
    {
        Log::info('Reward expiry check completed (testing mode).');
    }
}