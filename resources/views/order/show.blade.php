@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Order View</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Order</li>
    </ol>
</div>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto">
                <x-receipt :order="$order"/>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Order Detail</h3>
                    </div>
                    <div class="card-body">
                        <h5>Profit</h5>
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total Discount</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total_profit = 0; @endphp
                                @foreach ($order->orderDetails as $orderDetail)
                                <tr>
                                    <td>
                                        {{ $orderDetail->product->name }} ({{ $orderDetail->unit->name }})
                                    </td>
                                    <td>
                                        {{ $orderDetail->quantity }}
                                    </td>
                                    <td class="text-right">
                                        {{ Helper::numberFormatNoZeroes($orderDetail->subtotal_discount) }}
                                    </td>
                                    <td class="text-right">
                                        @php $profit = $orderDetail->total - ($orderDetail->stock_price * $orderDetail->quantity_total); $total_profit += $profit; @endphp 
                                        {{ number_format($profit, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3" class="text-right">TOTAL</th>
                                    <th class="text-right">{{ number_format($total_profit, 2) }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
