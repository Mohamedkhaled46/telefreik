<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trips';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $timestamp = true;
    protected $fillable = ["trip_id", "price", "from_location_id", "to_location_id", "stations_from", "stations_to",
                            "company", "seats", "class","tazcara"];

    protected $casts = [
        'stations_from' => 'json',
        'stations_to' => 'json'
    ];

    public function from_location(){
        return $this->belongsTo(Location::class,'from_location_id');
    }
    public function to_location(){
        return $this->belongsTo(Location::class,'to_location_id');
    }
}
