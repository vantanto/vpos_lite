@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Dashboard</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</div>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        @can('admin')
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ Helper::numberFormatNoZeroes($newOrder) }}</h3>
                        <p class="mb-0">New Order</p>
                        <small>Today</small>
                    </div>
                    <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ Helper::numberFormatNoZeroes($totalOrder) }}</h3>
                        <p class="mb-0">Total Order</p>
                        <small>Today</small>
                    </div>
                    <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ Helper::numberFormatNoZeroes($newPurchase) }}</h3>
                        <p class="mb-0">New Purchase</p>
                        <small>Today</small>
                    </div>
                    <div class="icon"><i class="fas fa-cart-plus"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ Helper::numberFormatNoZeroes($newCustomer) }}</h3>
                        <p class="mb-0">New Customer</p>
                        <small>This Month</small>
                    </div>
                    <div class="icon"><i class="fas fa-user"></i></div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Latest Orders</h3>
      
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lastOrders as $lastOrder)
                                    <tr>
                                        <td><a href="{{ route('orders.show', $lastOrder->code) }}">{{ $lastOrder->code }}</a></td>
                                        <td>{{ date('d/m/Y H:i', strtotime($lastOrder->date)) }}</td>
                                        <td>{{ $lastOrder->customer->name ?? \App\Models\Customer::$default }}</td>
                                        <td class="text-right">{{ Helper::numberFormatNoZeroes($lastOrder->discount) }}</td>
                                        <td class="text-right">{{ Helper::numberFormatNoZeroes($lastOrder->total) }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5">No Recent Order.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('orders.index') }}" class="uppercase">View All Orders</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Stock Activities</h3>
      
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body py-0">
                        <table class="table table-sm table-borderless">
                            <tbody>
                                @forelse ($lastStockFlows as $lastStockFlow)
                                <tr>
                                    @if ($lastStockFlow->type == "in")
                                    <td><a href="{{ route('purchases.show', $lastStockFlow->purchase_id) }}">{{ $lastStockFlow->product->name }}</a></td>
                                    <td class="text-center"><span class="badge badge-success">IN</span></td>
                                    <td class="text-right">{{ Helper::numberFormatNoZeroes($lastStockFlow->quantity_in) }}</td>
                                    @elseif ($lastStockFlow->type == "out")
                                    <td><a href="{{ route('orders.show', $lastStockFlow->order_id) }}">{{ $lastStockFlow->product->name }}</a></td>
                                    <td class="text-center"><span class="badge badge-danger">OUT</span></td>
                                    <td class="text-right">{{ Helper::numberFormatNoZeroes($lastStockFlow->quantity_out) }}</td>
                                    @endif
                                    <td>{{ $lastStockFlow->unit->name }}</td>
                                </tr>
                                @empty
                                <tr><td>No Recent Stock.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('reports.stocks.index') }}" class="uppercase">View All Stocks</a>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
</section>
@endsection