<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'gym_id', 'name', 'photo', 'email', 'contact', 'fee_due_date', 'fee_amount', 'status', 'joined_date'
    ];

    protected $casts = [
        'fee_due_date' => 'date',
        'joined_date' => 'date',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
