<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = ["name_en", "name_ar", "we_id", "tazcara_id", "blue_bus_id", "blue_bus_parent_id"];


}
