<?php

namespace App\Tasks;

use App\Models\Campaign;
use App\Models\Group;
use Illuminate\Support\Facades\DB;

class SyncGroupsUids
{
    public function __invoke()
    {
        $campaigns = Group::distinct()->where('keycloak_id', null)->pluck('campaign_id');

        if (!$campaigns) {
            return;
        }

        foreach ($campaigns as $campaignid) {
            $campaign = Campaign::find($campaignid);

            $keycloak = new \App\Util\Keycloak\Group();

            $groups = $keycloak->getKeycloakGroups($campaign);

            if (!$groups) {
                continue;
            }

            foreach ($groups as $keyCloakGroup) {
                $groupdata = $keycloak->getKeycloakGroup($campaign, $keyCloakGroup->id);

                if (!isset($groupdata->attributes->laravelid)) {
                    continue;
                }

                $appGroup = Group::find(current($groupdata->attributes->laravelid));

                if (!$appGroup || isset($appGroup->keycloak_id)) {
                    continue;
                }

                // Running direct update to avoid model dispatch update event.
                DB::table('groups')
                    ->where('id', $appGroup->id)
                    ->update(['keycloak_id' => $keyCloakGroup->id]);

                // Direct populate keycloak id to the object but without save the model in the database.
                $appGroup->keycloak_id = $keyCloakGroup->id;

                // Update remote keycloak group.
                $keycloak->updateKeycloakGroup($campaign, $appGroup);
            }
        }
    }
}
