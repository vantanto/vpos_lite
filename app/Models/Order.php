<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $filable = [
        'date', 'code', 'customer_id',
        'subtotal', 'additional', 'discount', 'tax',
        'total', 'total_pay', 'total_change',
        'user_id'
    ];

    public static function generateCode()
    {
        $lastOrder = Order::orderBy('id', 'desc')->withTrashed()->first();
        $lastOrderYear = Order::whereYear('date', date('Y'))->withTrashed()->count();
        return 
            'OD' .
            date('y') .
            (($lastOrder ? $lastOrder->id : 0) + 1).
            str_pad($lastOrderYear + 1, 5, "0", STR_PAD_LEFT);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::Class);
    }
}
