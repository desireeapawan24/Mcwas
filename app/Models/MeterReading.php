<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'plumber_id',
        'reading_date',
        'previous_reading',
        'present_reading',
        'used_cubic_meters',
        'period',
    ];

    protected $casts = [
        'reading_date' => 'date',
        'previous_reading' => 'decimal:4',
        'present_reading' => 'decimal:4',
        'used_cubic_meters' => 'decimal:4',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function plumber()
    {
        return $this->belongsTo(User::class, 'plumber_id');
    }
}



