<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'gym_id',
        'name',
        'role',
        'salary',
        'photo',
        'contact',
        'joined_date',
    ];

    protected function casts(): array
    {
        return [
            'joined_date' => 'date',
            'salary' => 'decimal:2',
        ];
    }

    public function gym(): BelongsTo
    {
        return $this->belongsTo(Gym::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(StaffPayment::class);
    }
}
