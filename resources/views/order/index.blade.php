@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Order List</h1>
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
            <div class="col-md-12">
                <form method="get" action="{{ request()->url() }}">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="code">Code</label>
                            <input type="text" id="code" name="code" class="form-control" 
                                value="{{ request()->input('code') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="date_start">Date Start</label>
                            <input type="date" id="date_start" name="date_start" class="form-control" 
                                value="{{ request()->input('date_start') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="date_end">Date End</label>
                            <input type="date" id="date_end" name="date_end" class="form-control" 
                                value="{{ request()->input('date_end') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="customer">Customer</label>
                            <select id="customer" name="customer" class="form-control">
                                <option value="">All Customer</option>
                                <option value="null" 
                                    @if (request()->input('customer') == 'null') selected @endif>
                                    {{ \App\Models\Customer::$default }}
                                </option>
                                @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" 
                                    @if (request()->input('customer') == $customer->id) selected @endif>
                                    {{ $customer->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <button type="submit" class="btn btn-outline-success">Apply Filter</button>
                        <a href="{{ request()->url() }}" class="btn btn-outline-secondary">Reset Filter</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Order List</h3>
                        <br>
                        <h3 class="card-title">
                            {{ date('d/m/Y', strtotime($dateStart)) }} - {{ date('d/m/Y', strtotime($dateEnd)) }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Discount</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration + $orders->firstItem() - 1 }}.</td>
                                    <td>{{ $order->code }}</td>
                                    <td>{{ date('d/m/Y H:i', strtotime($order->date)) }}</td>
                                    <td>{{ $order->customer->name ?? \App\Models\Customer::$default }}</td>
                                    <td>{{ $order->order_details_count }}</td>
                                    <td class="text-right">{{ Helper::numberFormatNoZeroes($order->discount) }}</td>
                                    <td class="text-right">{{ Helper::numberFormatNoZeroes($order->total) }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->code) }}" class="btn btn-info btn-sm">
                                            View
                                        </a>
                                        <form method="post" action="{{ route('orders.destroy', $order->code) }}" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmSwalAlert(this)">
                                                Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $orders->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
