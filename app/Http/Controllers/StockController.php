<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    // =============================== Section Purchase =============================== //
    /**
     * Average Product Buy Price & Addition Product Stock 
     * 
     * @param \App\Models\Product $product
     * @param \App\Models\PurchaseDetail $purchaseDetail
     * @return \App\Models\Product
     */
    public static function addStock($product, $purchaseDetail) 
    {
        $product->buy_price = (($product->stock * $product->buy_price) + $purchaseDetail->total) / ($product->stock + $purchaseDetail->quantity_total);
        $product->stock += $purchaseDetail->quantity_total;
        $product->save();
        return $product;
    }

    /**
     * Get Past Product Buy Price & Substraction Product Stock
     * 
     * @param \App\Models\Product $product
     * @param \App\Models\PurchaseDetail $purchaseDetail
     * @return \App\Models\Product
     */
    public static function rollbackAddStock($product, $purchaseDetail)
    {
        $product->buy_price = $product->stock - $purchaseDetail->quantity_total != 0
            ? (($product->buy_price * $product->stock) - $purchaseDetail->total) / ($product->stock - $purchaseDetail->quantity_total)
            : 0;
        $product->stock -= $purchaseDetail->quantity_total;
        return $product;
    }
    // ================================================================================ //
    
    
    // ================================ Section Order ================================= //
    /**
     * Average Product Buy Price & Addition Product Stock 
     * 
     * @param \App\Models\Product $product
     * @param integer $quantity
     * @return \App\Models\Product
     */
    public static function subStock($product, $quantity)
    {
        $product->stock -= $quantity;
        $product->save();
        return $product;
    }
    // ================================================================================ //
}
