<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pnotification extends Model
{
    use HasFactory;
    protected $table = 'pnotifications';
    protected $primaryKey = 'id';
    protected $fillable = [
        'customer_id',
        'pnotification_type_id',
        'title',
        'description',
        'link',
        'read',
    ];

    public function pnotificationType(): BelongsTo
    {
        return $this->belongsTo(PnotificationType::class, 'pnotification_type_id', 'id')->withDefault();
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withDefault();
    }
}
