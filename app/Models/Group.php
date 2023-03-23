<?php

namespace App\Models;

use App\Events\GroupCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'campaign_id',
    ];

    protected $dispatchesEvents = [
        'created' => GroupCreated::class,
    ];

    public function campaign(): BelongsTo
    {
        return $this->BelongsTo(Campaign::class);
    }
}
