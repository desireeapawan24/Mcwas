<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'accountant_id',
        'cubic_meters_used',
        'rate_per_cubic_meter',
        'total_amount',
        'amount_paid',
        'balance',
        'late_fee',
        'late_fee_applied',
        'billing_month',
        'due_date',
        'paid_date',
        'status',
        'payment_receipt',
    ];

    protected $casts = [
        'billing_month' => 'date',
        'due_date' => 'date',
        'paid_date' => 'date',
        'cubic_meters_used' => 'decimal:2',
        'rate_per_cubic_meter' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'balance' => 'decimal:2',
        'late_fee' => 'decimal:2',
        'late_fee_applied' => 'boolean',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function accountant()
    {
        return $this->belongsTo(User::class, 'accountant_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }

    public function scopePartiallyPaid($query)
    {
        return $query->where('status', 'partially_paid');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->where('status', '!=', 'paid');
    }

    // Helper methods
    public function calculateBalance()
    {
        $totalWithFees = $this->total_amount + ($this->late_fee ?? 0);
        $this->balance = max($totalWithFees - $this->amount_paid, 0); // never negative
        $this->save();
        
        if ($this->balance <= 0) {
            $this->status = 'paid';
            $this->paid_date = now();
        } elseif ($this->amount_paid > 0) {
            $this->status = 'partially_paid';
        } else {
            $this->status = 'unpaid';
        }
        
        $this->save();
    }

    public function isOverdue(): bool
    {
        return $this->due_date < now() && $this->status !== 'paid';
    }

    public function isFullyPaid(): bool
    {
        return $this->balance <= 0;
    }
}


