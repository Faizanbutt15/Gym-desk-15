<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    protected $fillable = [
        'name', 'address', 'logo', 'status', 'subscription_start', 'subscription_end'
    ];

    protected $casts = [
        'subscription_start' => 'date',
        'subscription_end' => 'date',
    ];

    public function admins()
    {
        return $this->hasMany(User::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function staffPayments()
    {
        return $this->hasMany(StaffPayment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
