<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'task_id',
        'changed_by',
        'old_status',
        'new_status',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
    ];
}
