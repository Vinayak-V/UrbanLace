<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'shoe_id',
        'name',
        'description',
        'design_json',
        'thumbnail_url',
        'is_active',
    ];

    protected $casts = [
        'design_json' => 'array',
    ];

    public function shoe()
    {
        return $this->belongsTo(Shoe::class);
    }
}
