@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Detail Product</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Master Data</a></li>
        <li class="breadcrumb-item active">Product</li>
    </ol>
</div>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Product</h3>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered table-striped">
                            <colgroup>
                                <col class="col-md-5">
                                <col class="col-md-7">
                            </colgroup>
                            <tr>
                                <th>Product Code</th>
                                <td>{{ $product->code }}</td>
                            </tr>
                            <tr>
                                <th>Product Name</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>Sell Price</th>
                                <td>{{ Helper::numberFormatNoZeroes($product->units[0]->sell_price) }}</td>
                            </tr>
                            <tr>
                                <th>Stock Unit</th>
                                <td>{{ $product->stockString() }}</td>
                            </tr>
                            <tr>
                                <th>Show on Transaction</th>
                                <td>
                                    @if($product->is_show) 
                                    <span class="badge badge-success">Active</span> 
                                    @else
                                    <span class="badge badge-secondary">Deactive</span> 
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered table-striped">
                            <colgroup>
                                <col class="col-md-5">
                                <col class="col-md-7">
                            </colgroup>
                            <tr>
                                <th>Category</th>
                                <td>{{ $product->category->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td>{{ Helper::numberFormatNoZeroes($product->discount) }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $product->description }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- Tab Unit --}}
        @if(count($product->units) > 1)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Unit</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <colgroup>
                        <col class="col-4">
                        <col class="col-4">
                        <col class="col-4">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Unit Name</th>
                            <th>Quantity <span id="hun_quantity_title">{{ ' Per ' . $product->units[0]->name }}</span></th>
                            <th>Price Per Unit</th>
                        </tr>
                    </thead>
                    <tbody id="body_add_unit">
                        @foreach($product->units as $keyUnit => $unit)
                        @if($keyUnit != 0)
                        <tr class="un_parent">
                            <td>
                                {{ $unit->name }}
                            </td>
                            <td>
                                {{ Helper::numberFormatNoZeroes($unit->quantity) }}
                            </td>
                            <td>
                                {{ Helper::numberFormatNoZeroes($unit->sell_price) }}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
@section('script')
@endsection
