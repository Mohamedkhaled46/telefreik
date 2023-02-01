<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "countries";

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'id', 'country_id');
    }
}
