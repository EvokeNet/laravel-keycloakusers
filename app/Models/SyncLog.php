<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SyncLog extends Model
{
    use HasFactory;

    protected $table = 'sync_logs';

    protected $fillable = [
        'model',
        'model_id',
        'action',
        'status',
        'message',
        'timesent',
        'extradata',
    ];

    public function group(): BelongsTo
    {
        return $this->BelongsTo(Group::class, 'model_id', 'id');
    }

    public function student(): BelongsTo
    {
        return $this->BelongsTo(Student::class, 'model_id', 'id');
    }
}
