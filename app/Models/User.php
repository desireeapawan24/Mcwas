<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'plain_password',
        'role',
        'age',
        'phone_number',
        'photo',
        'national_id',
        'address',
        'status',
        'is_available',
        'customer_number',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_available' => 'boolean',
    ];

    // Relationships
    public function waterBills(): HasMany
    {
        return $this->hasMany(WaterBill::class, 'customer_id');
    }

    public function processedBills(): HasMany
    {
        return $this->hasMany(WaterBill::class, 'accountant_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'accountant_id');
    }

    public function customerPayments(): HasMany
    {
        return $this->hasMany(Payment::class, 'customer_id');
    }

    public function waterConnections(): HasMany
    {
        return $this->hasMany(WaterConnection::class, 'plumber_id');
    }

    public function customerConnections(): HasMany
    {
        return $this->hasMany(WaterConnection::class, 'customer_id');
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPlumber(): bool
    {
        return $this->role === 'plumber';
    }

    public function isAccountant(): bool
    {
        return $this->role === 'accountant';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getCurrentBillAttribute()
    {
        // Match the first day-of-month stored format (e.g., 'Y-m-01')
        $currentMonth = now()->copy()->startOfMonth()->format('Y-m-d');
        return $this->waterBills()
            ->where('status', '!=', 'paid')
            ->where('billing_month', $currentMonth)
            ->first();
    }

    /**
     * Generate a unique customer number in format YYYY-XXXX
     */
    public static function generateCustomerNumber(): string
    {
        $currentYear = date('Y');
        $lastCustomer = self::where('customer_number', 'like', $currentYear . '-%')
            ->orderBy('customer_number', 'desc')
            ->first();

        if ($lastCustomer && $lastCustomer->customer_number) {
            $lastNumber = (int) substr($lastCustomer->customer_number, 5); // Extract number after YYYY-
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $currentYear . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
