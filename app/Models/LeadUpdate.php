<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadUpdate extends Model
{
    protected $fillable = [
        'contact_id',
        'admin_id',
        'status',
        'update_status',
        'follow_up_date',
        'notes',
        'pic_assigned',

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
