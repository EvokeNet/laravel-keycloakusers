<?php

namespace App\Util\Keycloak;

use App\Events\SynchronizationFailure;
use App\Events\SynchronizationSuccess;
use Illuminate\Support\Facades\Http;

class Group extends Base
{
    public function sendGroupToKeycloak(\App\Models\Group $group, $action = 'create') {
        $campaign = $group->campaign;

        $token = $this->getCampaignToken($campaign);

        $url = $this->baseUrl . '/admin/realms/' . $campaign->realm . '/groups';

        $response = Http::withToken($token)->post($url, [
            'name' => $group->name,
            'attributes' => [
                'groupname' => [$group->moodle_groupname],
                'courseid' => [$group->moodle_courseid],
                'laravelid' => [$group->id],
            ]
        ]);

        if ($response->status() == 201) {
            SynchronizationSuccess::dispatch($group, $action, $response->status(), $response->reason());

            return;
        }

        SynchronizationFailure::dispatch($group, $action, $response->status(), $response->reason());
    }

    public function getKeycloakGroups($campaign)
    {
        $token = $this->getCampaignToken($campaign);

        $url = $this->baseUrl . '/admin/realms/' . $campaign->realm . '/groups';

        $response = Http::withToken($token)->get($url);

        if ($response->status() != 200) {
            return false;
        }

        $body = $response->body();

        return json_decode($body);
    }

    public function getKeycloakGroup($campaign, $groupid)
    {
        $token = $this->getCampaignToken($campaign);

        $url = $this->baseUrl . '/admin/realms/' . $campaign->realm . '/groups/' . $groupid;

        $response = Http::withToken($token)->get($url);

        if ($response->status() != 200) {
            return false;
        }

        $body = $response->body();

        return json_decode($body);
    }

    public function updateKeycloakGroup($campaign, $group)
    {
        $token = $this->getCampaignToken($campaign);

        if (is_null($group->keycloak_id)) {
            SynchronizationFailure::dispatch($group, 'update', 425, 'Too Early');

            return;
        }

        $url = $this->baseUrl . '/admin/realms/' . $campaign->realm . '/groups/' . $group->keycloak_id;

        $response = Http::withToken($token)->put($url, [
            'name' => $group->name,
            'attributes' => [
                'groupname' => [$group->moodle_groupname],
                'courseid' => [$group->moodle_courseid],
            ]
        ]);

        if ($response->status() == 204) {
            SynchronizationSuccess::dispatch($group, 'update', $response->status(), 'Updated');

            return;
        }

        SynchronizationFailure::dispatch($group, 'update', $response->status(), $response->reason());
    }
}
