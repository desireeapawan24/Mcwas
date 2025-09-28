<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisconnectionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'requested_by',
        'assigned_plumber_id',
        'status',
        'due_since',
        'notes',
    ];

    protected $casts = [
        'due_since' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function plumber()
    {
        return $this->belongsTo(User::class, 'assigned_plumber_id');
    }
}



