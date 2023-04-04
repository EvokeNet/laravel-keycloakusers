<?php

namespace App\Models;

use App\Events\GroupCreated;
use App\Events\GroupUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'name',
        'moodle_groupname',
        'moodle_courseid',
        'keycloak_id'
    ];

    protected $dispatchesEvents = [
        'created' => GroupCreated::class,
        'updated' => GroupUpdated::class,
    ];

    public function campaign(): BelongsTo
    {
        return $this->BelongsTo(Campaign::class);
    }
}
