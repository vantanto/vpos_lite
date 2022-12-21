<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'purchase_id', 'product_id', 'unit_id',
        'quantity', 'quantity_total', 
        'price', 'discount', 'subtotal', 'subtotal_discount',
        'total',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
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
