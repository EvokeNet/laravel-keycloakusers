<?php

namespace App\Models;

use App\Events\CampaignCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'realm',
        'client_id',
        'client_secret',
        'moodle_coursetemplateid',
        'moodle_courseshortname',
        'moodle_coursefullname',
    ];

    protected $dispatchesEvents = [
        'created' => CampaignCreated::class,
//        'updated' => CampaignUpdated::class,
    ];
}
