<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'shoe_id',
        'shoe_design_id',
        'design_snapshot',
        'design_thumbnail',
        'size',
        'quantity',
        'price_snapshot',
    ];

    protected $casts = [
        'design_snapshot' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function shoe()
    {
        return $this->belongsTo(Shoe::class);
    }

    public function shoeDesign()
    {
        return $this->belongsTo(ShoeDesign::class);
    }
}
