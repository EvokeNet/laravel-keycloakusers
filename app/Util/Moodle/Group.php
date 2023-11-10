<?php

namespace App\Util\Moodle;

use Illuminate\Support\Facades\Http;

class Group
{
    protected $url;
    protected $token;
    public function __construct()
    {
        $url = config('moodle.baseurl');
        $token = config('moodle.token');

        if (!$url || !$token) {
            throw new \Exception('You need to configure Moodle URL and Token');
        }

        $this->url = $url;
        $this->token = $token;
    }

    public function sendGroupToMoodle($group) {
        // No Moodle course creation, do nothing.
        if (!$group->moodle_courseid) {
            return false;
        }

        $function = 'local_evokews_create_group';

        $url =  "{$this->url}/webservice/rest/server.php?wstoken={$this->token}&wsfunction={$function}&moodlewsrestformat=json";

        $response = Http::asForm()->post($url, [
            'courseid' => $group->moodle_courseid,
            'name' => $group->name,
        ]);

        if (isset($response['exception'])) {
            throw new \Exception($response['message']);
        }

        return true;
    }
}
