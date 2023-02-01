<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    protected $table = 'states';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id', 'state_id');
    }
}
