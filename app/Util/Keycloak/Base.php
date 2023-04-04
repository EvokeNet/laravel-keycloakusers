<?php

namespace App\Util\Keycloak;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class Base
{
    protected $baseUrl = null;

    public function __construct()
    {
        $this->baseUrl = config('keycloak.baseurl');
    }

    protected function getCampaignToken($campaign)
    {
        // Token expired or will expire in the next 10 seconds.
        if (time() >= $campaign->expires - 10) {
            return $this->getNewCampaignToken($campaign);
        }

        return $campaign->token;
    }

    protected function getNewCampaignToken($campaign)
    {
        $url = $this->baseUrl . '/realms/' . $campaign->realm . '/protocol/openid-connect/token';

        $response = Http::asForm()->post($url, [
            'grant_type' => 'password',
            'username' => Crypt::decryptString($campaign->username),
            'password' => Crypt::decryptString($campaign->password),
            'client_id' => Crypt::decryptString($campaign->client_id),
        ]);

        if ($response->status() != 200) {
            return false;
        }

        $body = json_decode($response->body());

        $campaign->token = $body->access_token;
        $campaign->expires = time() + $body->expires_in;
        $campaign->save();

        return $body->access_token;
    }
}
