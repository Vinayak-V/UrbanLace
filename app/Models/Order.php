<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coupon_id',
        'delivery_option_id',
        'status',
        'subtotal',
        'discount',
        'delivery_fee',
        'total',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'shipping_phone',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tracking()
    {
        return $this->hasMany(OrderTracking::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
