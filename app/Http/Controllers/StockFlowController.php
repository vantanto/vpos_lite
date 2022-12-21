<?php

namespace App\Http\Controllers;

use App\Models\StockFlow;
use Illuminate\Http\Request;

class StockFlowController extends Controller
{
    // =============================== Section Purchase =============================== //
    /**
     * Average Product Buy Price & Addition Product Stock & Insert Stock Flow
     * 
     * @param \App\Models\Product $product
     * @param \App\Models\Purchase $purchase
     * @param \App\Models\PurchaseDetail $purchaseDetail
     * @param string $method [store | update]
     * @return \App\Models\Product
     */
    public static function addStock($product, $purchase, $purchaseDetail, $method = "store") 
    {
        $product->buy_price = (($product->stock * $product->buy_price) + $purchaseDetail->total) / ($product->stock + $purchaseDetail->quantity_total);
        $product->stock += $purchaseDetail->quantity_total;
        $product->save();

        $stockFlow = new StockFlow();
        if ($method == "update") $stockFlow = $purchaseDetail->stockFlow;
        $stockFlow->date = $purchase->date;
        $stockFlow->type = "in";
        $stockFlow->product_id = $purchaseDetail->product_id;
        $stockFlow->unit_id = $purchaseDetail->unit_id;
        $stockFlow->purchase_id = $purchase->id;
        $stockFlow->purchase_detail_id = $purchaseDetail->id;
        $stockFlow->quantity_in = $purchaseDetail->quantity;
        $stockFlow->quantity_total_in = $purchaseDetail->quantity_total;
        $stockFlow->save();
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
     * @param \App\Models\Order $order
     * @param \App\Models\OrderDetail $orderDetail
     * @param string $methode [store | update]
     * @return \App\Models\Product
     */
    public static function subStock($product, $order, $orderDetail, $method = "store")
    {
        $product->stock -= $orderDetail->quantity_total;
        $product->save();

        $stockFlow = new StockFlow();
        if ($method == "update") $stockFlow = $orderDetail->stockFlow;
        $stockFlow->date = $order->date;
        $stockFlow->type = "out";
        $stockFlow->product_id = $orderDetail->product_id;
        $stockFlow->unit_id = $orderDetail->unit_id;
        $stockFlow->order_id = $order->id;
        $stockFlow->order_detail_id = $orderDetail->id;
        $stockFlow->quantity_out = $orderDetail->quantity;
        $stockFlow->quantity_total_out = $orderDetail->quantity_total;
        $stockFlow->save();
        return $product;
    }
    // ================================================================================ //
}
