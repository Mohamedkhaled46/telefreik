<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketReservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'price',
        'departure',
        'arrival',
        'child_count',
        'adult_count',
        'departure_at',
        'arrive_at',
        'kind',
        'type',
        'status',
        'provider_id',
        'customer_id',
    ];

    protected $casts = [
        'price' => 'float',
        'departure_at' => 'datetime',
        'arrive_at' => 'datetime',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
