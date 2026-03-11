<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GymPayment extends Model
{
    protected $fillable = [
        'gym_id',
        'amount',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}
