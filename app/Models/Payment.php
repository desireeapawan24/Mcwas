<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'water_bill_id',
        'customer_id',
        'accountant_id',
        'amount_paid',
        'payment_method',
        'reference_number',
        'notes',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
    ];

    // Relationships
    public function waterBill()
    {
        return $this->belongsTo(WaterBill::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function accountant()
    {
        return $this->belongsTo(User::class, 'accountant_id');
    }
}

