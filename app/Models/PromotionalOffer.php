<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class PromotionalOffer extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    public $translatable = [
        'title',
        'brief',
    ];

    protected $fillable = [
        'title',
        'brief',
        'image',
        'active',
        'user_id',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
