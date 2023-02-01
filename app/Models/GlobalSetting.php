<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalSetting extends Model
{
    use HasFactory;

    protected $table = 'global_setting';
    protected $primaryKey = 'id';
    protected $guarded=['id'];
    public static $uploads_path = 'uploads/settings';
}
