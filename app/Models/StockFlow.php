<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockFlow extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date', 'type', 'product_id', 'unit_id',
        'order_id', 'order_detail_id',
        'purchase_id', 'purchase_detail_id',
        'quantity_in', 'quantity_total_in',
        'quantiyy_out', 'quantity_total_out',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function purchaseDetail()
    {
        return $this->belongsTo(PurchaseDetail::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
