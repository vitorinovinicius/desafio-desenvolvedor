<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $connection = 'mysql'; // ou config('activitylog.database_connection') se você quiser dinâmico
    protected $table = 'activity_log'; // ou config('activitylog.table_name')

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo('subject');
    }

    public function causer(): MorphTo
    {
        return $this->morphTo('causer');
    }
}
