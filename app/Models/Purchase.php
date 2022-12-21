<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date', 'subtotal', 'additional', 'discount',
        'total', 'description',
        'supplier_id', 'user_id',
    ];

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockFlows()
    {
        return $this->hasMany(StockFlow::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
