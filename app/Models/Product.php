<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'name', 
        'buy_price', 'discount', 
        'stock', 'category_id', 'is_show',
    ];

    protected $hidden = [
        'buy_price',
    ];

    protected $casts = [
        'is_show' => 'boolean',
    ];

    public function stockString($quantity = 'default')
    {
        $stockString = "";
        $productUnits = $this->units->sortByDesc('quantity');
        $stock_temp = $quantity == 'default' ? $this->stock : $quantity;
        foreach ($productUnits as $productUnit) {
            $stockUnit = $stock_temp > 0 ? floor($stock_temp / $productUnit->quantity) : 0;
            $stockString .=  Helper::numberFormatNoZeroes($stockUnit) . " {$productUnit->name} "; 
            if ($stockUnit != 0) $stock_temp -= $stockUnit * $productUnit->quantity;
        }
        return $stockString;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
