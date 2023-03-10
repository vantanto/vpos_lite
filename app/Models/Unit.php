<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'product_id', 'quantity', 'sell_price', 'name', 
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
