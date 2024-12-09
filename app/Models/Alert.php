<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = [
        'user_id',
        'alert_type',
        'message',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

