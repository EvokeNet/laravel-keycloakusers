<?php

namespace App\Util\Keycloak;

use App\Events\SynchronizationFailure;
use App\Events\SynchronizationSuccess;
use App\Models\Student;
use Illuminate\Support\Facades\Http;

class User extends Base
{
    public function sendUserToKeycloak(Student $student, $action = 'create') {
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

        if ($response->status() == 201) {
            SynchronizationSuccess::dispatch($student, $action, $response->status(), $response->reason());

            return;
        }

        SynchronizationFailure::dispatch($student, $action, $response->status(), $response->reason());
    }
}
