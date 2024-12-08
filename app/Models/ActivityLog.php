<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'admin_id',
        'activity',
        'details',
        'created_at',
        'role'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
