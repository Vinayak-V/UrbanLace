<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoeDesign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shoe_id',
        'design_json',
        'share_token',
        'thumbnail_url',
        'name',
    ];

    protected $casts = [
        'design_json' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shoe()
    {
        return $this->belongsTo(Shoe::class);
    }
}
