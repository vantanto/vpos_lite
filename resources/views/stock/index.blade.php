@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Stock List</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Report</a></li>
        <li class="breadcrumb-item active">Stock</li>
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
                            @php $fproducts = request()->input('fproducts') ?? []; @endphp
                            <label for="fproducts">Product</label>
                            <select id="fproducts" name="fproducts[]" class="form-control" multiple>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}" @if(in_array($product->id, $fproducts)) selected @endif>
                                    {{ $product->name }}
                                </option>
                                @endforeach
                            </select>
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
                        <h3 class="card-title">Stock List</h3>
                        <br>
                        <h4 class="card-title">{{ $dateStart->format('d/m/Y') }} - {{ $dateEnd->format('d/m/Y') }}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Stock In</th>
                                    <th>Stock Out</th>
                                    <th>Current Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productStocks as $productStock)
                                <tr>
                                    <td>{{ $productStock->name }}</td>
                                    <td>{{ $productStock->stockString($productStock->sum_qty_total_in) }}</td>
                                    <td>{{ $productStock->stockString($productStock->sum_qty_total_out) }}</td>
                                    <td>{{ $productStock->stockString($productStock->stock - $productStock->sum_csf_qty_total_in + $productStock->sum_csf_qty_total_out) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $productStocks->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    $("#fproducts").select2({
        placeholder: 'Select Product'
    });
</script>
@endsection
