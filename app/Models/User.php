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
        'role',
        'age',
        'phone_number',
        'photo',
        'national_id',
        'address',
        'status',
        'is_available',
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
        return $this->waterBills()
            ->where('status', '!=', 'paid')
            ->where('billing_month', now()->format('Y-m'))
            ->first();
    }
}
