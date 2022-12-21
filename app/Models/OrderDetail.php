<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id', 'product_id', 'unit_id',
        'quantity', 'quantity_total', 
        'stock_price', 'price', 'discount', 
        'subtotal', 'subtotal_discount', 'total',
    ];

    protected $hidden = [
        'stock_price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::Class);
    }

    public function stockFlow()
    {
        return $this->hasOne(StockFlow::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
