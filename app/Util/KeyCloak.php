<?php

namespace App\Util;

use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class KeyCloak
{
    protected $baseUrl = null;

    public function __construct()
    {
        $this->baseUrl = config('keycloak.baseurl');
    }

    public function getCampaignToken($campaign)
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

    public function sendUserToKeycloak(Student $student) {
        $campaign = $student->campaign;

        $token = $this->getCampaignToken($campaign);

        $url = $this->baseUrl . '/admin/realms/' . $campaign->realm . '/users';

        $response = Http::withToken($token)->post($url, [
            'email' => $student->email,
            'emailVerified' => true,
            'firstName' => $student->firstname,
            'lastName' => $student->lastname,
            'username' => $student->email,
            'enabled' => true,
            'groups' => [$student->group->name],
        ]);

        // status = 409 = conflict = user already exists
        if ($response->status() == 409) {
            return false;
        }

        if ($response->status() != 201) {
            return false;
        }

        return true;
    }

    public function sendGroupToKeycloak(Group $group) {
        $campaign = $group->campaign;

        $token = $this->getCampaignToken($campaign);

        $url = $this->baseUrl . '/admin/realms/' . $campaign->realm . '/groups';

        $response = Http::withToken($token)->post($url, [
            'name' => $group->name,
        ]);

        // status = 409 = conflict = user already exists
        if ($response->status() == 409) {
            return false;
        }

        if ($response->status() != 201) {
            return false;
        }

        return true;
    }
}
