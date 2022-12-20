@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Detail Purchase</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Purchase</li>
    </ol>
</div>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card col-lg-6">
            <div class="card-header">
                <h3 class="card-title">Detail Purchase</h3>
            </div>
            
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                    <colgroup>
                        <col class="col-md-4">
                        <col class="col-md-8">
                    </colgroup>
                    <tr>
                        <th>Date</th>
                        <td>{{ date('d/m/Y', strtotime($purchase->date)) }}</td>
                    </tr>
                    <tr>
                        <th>Supplier</th>
                        <td>{{ $purchase->supplier->name }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>{{ Helper::numberFormatNoZeroes($purchase->total) }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $purchase->description }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5>Product</h5>
                <table class="table table-bordered table-striped">
                    <colgroup>
                        <col class="col-4">
                        <col class="col-2">
                        <col class="col-3">
                        <col class="col-3">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="body_add_product">
                        @foreach($purchase->purchaseDetails as $purchaseDetail)
                        <tr class="product_parent">
                            <td>
                                {{ $purchaseDetail->product->name }} ({{ $purchaseDetail->unit->name }})
                            </td>
                            <td>
                                {{ Helper::numberFormatNoZeroes($purchaseDetail->quantity) }}
                            </td>
                            <td>
                                {{ Helper::numberFormatNoZeroes($purchaseDetail->price) }}
                            </td>
                            <td>
                                {{ Helper::numberFormatNoZeroes($purchaseDetail->total) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection