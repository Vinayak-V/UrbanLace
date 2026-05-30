<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'shoe_id',
        'name',
        'mesh_name',
        'default_color',
    ];

    public function shoe()
    {
        return $this->belongsTo(Shoe::class);
    }
}
