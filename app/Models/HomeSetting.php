<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    use HasFactory;
    protected $table = 'home_settings';
    public static $uploads_path = 'global_settings/';

    protected $guarded =[];
}
