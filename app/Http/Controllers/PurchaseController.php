<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::all();
        $purchases = Purchase::with(['supplier']);
        if ($request->date_start && $request->date_end) {
            $purchases->whereBetween('date', [$request->date_start, $request->date_end]);
        }
        if ($request->supplier) {
            $purchases->where('supplier_id', $request->supplier);
        }
        $purchases = $purchases->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('purchase.index', compact('suppliers', 'purchases'));
    }

    public function create(Request $request)
    {
        $suppliers = Supplier::all();
        $products = Product::with(['units'])->get();
        return view('purchase.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'date' => 'required',
            'purchaseDetails' => 'required|min:1',
            'purchaseDetails.*.product_id' => 'required|exists:products,id',
            'purchaseDetails.*.unit_id' => 'required|exists:units,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $dataPurchase = $request->all();

            $purchase = new Purchase();
            $purchase->date = $dataPurchase['date'];
            $purchase->subtotal = $dataPurchase['total'];
            $purchase->discount = $dataPurchase['discount'] ?? 0;
            $purchase->additional = $dataPurchase['additional'] ?? 0;
            $purchase->total = $dataPurchase['total'];
            $purchase->description = $dataPurchase['description'];
            $purchase->supplier_id = $dataPurchase['supplier_id'];
            $purchase->user_id = $user->id;
            $purchase->save();

            foreach ($dataPurchase['purchaseDetails'] as $pd) {
                if ($pd['qty'] > 0) {
                    $product = Product::find($pd['product_id']);
                    $unit = Unit::find($pd['unit_id']);
                    $purchaseDetail = new PurchaseDetail();
                    $purchaseDetail->purchase_id = $purchase->id;
                    $purchaseDetail->product_id = $pd['product_id'];
                    $purchaseDetail->unit_id = $pd['unit_id'];
                    $purchaseDetail->quantity = $pd['qty'];
                    $purchaseDetail->quantity_total = $pd['qty'] * $unit->quantity;
                    $purchaseDetail->price = $pd['price'];
                    $purchaseDetail->discount = $pd['discount'] ?? 0;
                    $purchaseDetail->subtotal = $purchaseDetail->quantity * $purchaseDetail->price;
                    $purchaseDetail->subtotal_discount = $purchaseDetail->quantity * $purchaseDetail->discount;
                    $purchaseDetail->total = $purchaseDetail->subtotal - $purchaseDetail->subtotal_discount;
                    $purchaseDetail->save();

                    // Update Product Stock & Buy Price
                    StockFlowController::addStock($product, $purchase, $purchaseDetail, "store");
                }
            }

            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'Purchase Successfully Created'], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => 'Purchase Failed Created'], 500);
        }
    }

    public function show(Request $request, $id)
    {
        $purchase = Purchase::with(['purchaseDetails.product', 'purchaseDetails.unit'])
            ->where('id', $id)->first();
        return view('purchase.show', compact('purchase'));
    }

    public function edit(Request $request, $id)
    {
        $suppliers = Supplier::all();
        $products = Product::with(['units'])->get();
        $purchase = Purchase::with(['purchaseDetails.product', 'purchaseDetails.product'])
            ->where('id', $id)->first();
        return view('purchase.edit', compact('suppliers', 'products', 'purchase'));
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'date' => 'required',
            'purchaseDetails' => 'required|min:1',
            'purchaseDetails.*.product_id' => 'required|exists:products,id',
            'purchaseDetails.*.unit_id' => 'required|exists:units,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $dataPurchase = $request->all();

            $purchase = Purchase::find($id);
            $purchase->date = $dataPurchase['date'];
            $purchase->subtotal = $dataPurchase['total'];
            $purchase->discount = $dataPurchase['discount'] ?? 0;
            $purchase->additional = $dataPurchase['additional'] ?? 0;
            $purchase->total = $dataPurchase['total'];
            $purchase->description = $dataPurchase['description'];
            $purchase->supplier_id = $dataPurchase['supplier_id'];
            $purchase->user_id = $user->id;
            $purchase->save();
            
            foreach ($dataPurchase['purchaseDetails'] as $pd) {
                if ($pd['qty'] > 0) {
                    $product = Product::find($pd['product_id']);
                    $unit = Unit::find($pd['unit_id']);
                    $purchaseDetail = new PurchaseDetail();
                    if (isset($pd['id'])) {
                        $purchaseDetail = PurchaseDetail::find($pd['id']);
                        
                        // Rollback Product Stock & Buy Price
                        $product = StockFlowController::rollbackAddStock($product, $purchaseDetail);
                    }
                    $purchaseDetail->purchase_id = $purchase->id;
                    $purchaseDetail->product_id = $pd['product_id'];
                    $purchaseDetail->unit_id = $pd['unit_id'];
                    $purchaseDetail->quantity = $pd['qty'];
                    $purchaseDetail->quantity_total = $pd['qty'] * $unit->quantity;
                    $purchaseDetail->price = $pd['price'];
                    $purchaseDetail->discount = $pd['discount'] ?? 0;
                    $purchaseDetail->subtotal = $purchaseDetail->quantity * $purchaseDetail->price;
                    $purchaseDetail->subtotal_discount = $purchaseDetail->quantity * $purchaseDetail->discount;
                    $purchaseDetail->total = $purchaseDetail->subtotal - $purchaseDetail->subtotal_discount;
                    $purchaseDetail->save();

                    // Update Product Stock & Buy Price
                    StockFlowController::addStock($product, $purchase, $purchaseDetail, "update");
                }
            }

            // Delete Purchase Details
            if ($dataPurchase['deletedPurchaseDetails']) {
                $deletedPurchaseDetails = PurchaseDetail::with('product')->whereIn('id', $dataPurchase['deletedPurchaseDetails'])->get();
                foreach ($deletedPurchaseDetails as $purchaseDetail) {
                    // Rollback Product Stock & Buy Price
                    $product = StockFlowController::rollbackAddStock($purchaseDetail->product, $purchaseDetail);
                    $product->save();
                }
                StockFlowController::whereIn('purchase_detail_id', $dataPurchase['deletedPurchaseDetails'])->delete();
                $deletedPurchaseDetails->delete();
            }

            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'Purchase Successfully Updated'], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => 'Purchase Failed Updated'], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::with('purchaseDetails.product')->where('id', $id)->first();
            foreach ($purchase->purchaseDetails as $purchaseDetail) {
                // Rollback Product Stock & Buy Price
                $product = StockFlowController::rollbackAddStock($purchaseDetail->product, $purchaseDetail);
                $product->save();
            }
            $purchase->stockFlows()->delete();
            $purchase->purchaseDetails()->delete();
            $purchase->delete();

            DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Purchase Successfully Deleted');
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Purchase Failed Deleted');
        }
    }
}
