@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Purchase Statement</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Report</a></li>
        <li class="breadcrumb-item active">Purchase Statement</li>
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
                            <label for="fmonth">Month</label>
                            <input type="month" id="fmonth" name="fmonth" class="form-control" 
                                value="{{ request()->input('fmonth') }}">
                        </div>
                    </div>
                    <div class="form-group ">
                        <button type="submit" class="btn btn-outline-success">Apply Filter</button>
                        <a href="{{ request()->url() }}" class="btn btn-outline-secondary">Reset Filter</a>
                        <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}" target="_blank" class="btn bg-maroon ml-3">Export PDF</a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Purchase Statement</h3>
                        <br>
                        <h4 class="card-title">{{ $dateStart->format('F Y') }}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseStatements as $purchaseStatement)                                    
                                <tr>
                                    <td>{{ $purchaseStatement->name }}</td>
                                    <td>{{ $purchaseStatement->stockString($purchaseStatement->sum_pud_quantity_total) }}</td>
                                    <td class="text-right">{{ Helper::numberFormatNoZeroes($purchaseStatement->sum_pud_total) }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th class="text-right">{{ Helper::numberFormatNoZeroes($purchaseStatements->sum('sum_pud_total')) }}</th>
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
