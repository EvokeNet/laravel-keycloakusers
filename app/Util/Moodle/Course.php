<?php

namespace App\Util\Moodle;

use Illuminate\Support\Facades\Http;

class Course
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

    public function getAll() {
        $function = 'local_evokews_get_all_campaigns';

        $url =  "{$this->url}/webservice/rest/server.php?wstoken={$this->token}&wsfunction={$function}&moodlewsrestformat=json";

        $response = Http::get($url)->json();

        if (isset($response['exception'])) {
            throw new \Exception($response['message']);
        }

        return array_map(fn($item) => (object) $item, $response);
    }

    public function sendCourseToMoodle($campaign) {
        // No Moodle course creation, do nothing.
        if (!$campaign->moodle_courseshortname || !$campaign->moodle_coursefullname) {
            return false;
        }

        // Create new course.
        if (!$campaign->moodle_coursetemplateid) {
            $function = 'local_evokews_create_campaign';

            $url =  "{$this->url}/webservice/rest/server.php?wstoken={$this->token}&wsfunction={$function}&moodlewsrestformat=json";

            $response = Http::asForm()->post($url, [
                'shortname' => $campaign->moodle_courseshortname,
                'fullname' => $campaign->moodle_coursefullname
            ]);

            if (isset($response['exception'])) {
                throw new \Exception($response['message']);
            }

            $campaign->moodle_courseid = $response['id'];

            return $campaign->save();
        }

        $function = 'local_evokews_duplicate_campaign';

        $url =  "{$this->url}/webservice/rest/server.php?wstoken={$this->token}&wsfunction={$function}&moodlewsrestformat=json";

        $response = Http::asForm()->post($url, [
            'courseid' => $campaign->moodle_coursetemplateid,
            'shortname' => $campaign->moodle_courseshortname,
            'fullname' => $campaign->moodle_coursefullname
        ]);

        if (isset($response['exception'])) {
            throw new \Exception($response['message']);
        }

        $campaign->moodle_courseid = $response['id'];

        return $campaign->save();
    }
}
