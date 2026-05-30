<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_price',
        'model_type',
        'description',
        'thumbnail',
        'is_active',
    ];

    public function colorZones()
    {
        return $this->hasMany(ColorZone::class);
    }

    public function designs()
    {
        return $this->hasMany(ShoeDesign::class);
    }
}
