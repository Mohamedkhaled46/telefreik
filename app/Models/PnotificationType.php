<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PnotificationType extends Model
{
    use HasFactory;
    protected $table = 'pnotification_types';
    protected $primaryKey = 'id';


    public function pnotifications(): HasMany
    {
        return $this->hasMany(Pnotification::class, 'id', 'pnotification_type_id');
    }
}
