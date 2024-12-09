<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedImport extends Model
{
    protected $fillable = [
        'file_name',
        'error_message',
        'created_at',
    ];
}
