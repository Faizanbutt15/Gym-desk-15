<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'staff_id',
        'amount',
        'paid_date',
    ];

    protected function casts(): array
    {
        return [
            'paid_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function gym(): BelongsTo
    {
        return $this->belongsTo(Gym::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class)->withTrashed();
    }
}
