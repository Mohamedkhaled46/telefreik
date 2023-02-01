<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Provider extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded =[];

    

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getLogoAttribute($value)
    {
        return url(Storage::url("providers/{$value}"));
    }

}
