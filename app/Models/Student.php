<?php

namespace App\Models;

use App\Events\StudentCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'campaign_id',
        'group_id',
    ];

    public function group(): BelongsTo
    {
        return $this->BelongsTo(Group::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->BelongsTo(Campaign::class);
    }

    protected $dispatchesEvents = [
        'created' => StudentCreated::class,
    ];
}
