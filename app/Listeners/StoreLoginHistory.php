<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use App\Models\LoginHistory;

class StoreLoginHistory
{
    public function handle(Login $event)
    {
        $agent = new Agent();
        $ip = Request::getClientIp();

        // Free IP location API
        $location = Http::get("http://ip-api.com/json/{$ip}")->json();

        LoginHistory::create([
            'user_id'   => $event->user->id,
            'ip_address' => $ip,
            'country'   => $location['country'] ?? null,
            'city'      => $location['city'] ?? null,
            'device'    => $agent->isDesktop() ? 'Desktop' : 'Mobile',
            'browser'   => $agent->browser(),
            'os'        => $agent->platform(),
            'logged_in_at' => now(),
        ]);
    }
}
