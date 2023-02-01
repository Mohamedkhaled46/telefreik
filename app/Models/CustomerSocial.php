<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerSocial extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "customer_socials";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'social_UUID',
        'logged_by',
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, "customer_id", "id");
    }
}
