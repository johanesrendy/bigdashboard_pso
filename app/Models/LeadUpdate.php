<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadUpdate extends Model
{
    protected $fillable = [
        'contact_id',
        'admin_id',
        'status',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
