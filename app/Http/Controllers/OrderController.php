<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::all();
        $dateStart = $request->date_start ?? date('Y-m-01');
        $dateEnd = $request->date_end ?? date('Y-m-d');

        $orders = Order::with(['customer'])
            ->withCount('orderDetails')
            ->whereBetween('date', [$dateStart." 00:00:00", $dateEnd." 23:59:59"]);
        if ($request->code) {
            $orders->where('code', 'like', '%'.$request->code.'%');
        }
        if ($request->customer) {
            $orders->where('customer_id', $request->customer != 'null' ?: null);
        }
        $orders = $orders->orderBy('date', 'desc')
            ->paginate(15);
        return view('order.index', compact('customers', 'orders', 'dateStart', 'dateEnd'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::with(['units'])
            ->where('is_show', true)->get();
        return view('order.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'customer.id' => 'nullable',
            'orderDetails' => 'required|min:1',
            'orderDetails.*.product_id' => 'required|exists:products,id',
            'orderDetails.*.unit_id' => 'required|exists:units,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $dataCustomer = $request->customer;
            $dataOrder =  $request->except('customer');

            $order = new Order();
            $order->date = now();
            $order->code = Order::generateCode();
            $order->customer_id = $dataCustomer ? $dataCustomer['id'] : null;
            $order->subtotal = $dataOrder['subtotal'];
            // $order->additional = $dataOrder['additional'] ?? 0;
            $order->discount = $dataOrder['discount'] ?? 0;
            $order->tax = $dataOrder['tax'] ?? 0;
            $order->total = $dataOrder['total'];
            $order->total_pay = $dataOrder['pay'];
            $order->total_change = $dataOrder['change'];
            $order->user_id = $user->id;
            $order->save();

            foreach ($dataOrder['orderDetails'] as $od) {
                if ($od['qty'] > 0) {
                    $product = Product::find($od['product_id']);
                    $unit = Unit::find($od['unit_id']);
                    $orderDetail = new OrderDetail();
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $od['product_id'];
                    $orderDetail->unit_id = $od['unit_id'];
                    $orderDetail->quantity = $od['qty'];
                    $orderDetail->quantity_total = $od['qty'] * $unit->quantity;
                    $orderDetail->stock_price = $product->buy_price;
                    $orderDetail->price = $unit->sell_price;
                    $orderDetail->discount = $od['discount'] ?? 0;
                    $orderDetail->subtotal = $orderDetail->quantity * $unit->sell_price;
                    $orderDetail->subtotal_discount = $orderDetail->quantity * $orderDetail->discount;
                    $orderDetail->total = $orderDetail->subtotal - $orderDetail->subtotal_discount;
                    $orderDetail->save();

                    // Update Product Stock
                    StockFlowController::subStock($product, $order, $orderDetail, "store");
                }
            }

            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'Order Successfully Created', 'order_code' => $order->code], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => $ex->getMessage()], 500);
            return response()->json(['status' => 'error', 'msg' => 'Order Failed Created'], 500);
        }
    }

    public function destroy(Request $request, $code)
    {
        $order = Order::where('code', $code)->first();
        $order->orderDetails()->delete();
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order Successfully Deleted');
    }

    public function show(Request $request, $code)
    {
        $order = Order::with([
                'orderDetails',
                'orderDetails.product',
                'orderDetails.unit',
            ])
            ->where('code', $code)->first();
        return view('order.show', compact('order'));
    }

    public function receipt(Request $request, $code)
    {
        $order = Order::with([
                'orderDetails',
                'orderDetails.unit',
            ])
            ->where('code', $code)->first();
        return view('receipt.show', compact('order'));
    }
}
