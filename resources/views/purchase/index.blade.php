@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Purchase List</h1>
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
                            <label for="supplier">Supplier</label>
                            <select class="form-control" id="supplier" name="supplier">
                                <option value="" selected>All Supplier</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    @if($supplier->id == request()->input('supplier')) selected @endif>
                                    {{ $supplier->name }}
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
                        <h3 class="card-title">Purchase List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Supplier</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $purchase)
                                <tr>
                                    <td>{{ $loop->iteration + $purchases->firstItem() - 1 }}.</td>
                                    <td>{{ date('d/m/Y', strtotime($purchase->date)) }}</td>
                                    <td>{{ $purchase->supplier->name }}</td>
                                    <td>{{ Helper::numberFormatNoZeroes($purchase->total) }}</td>
                                    <td>
                                        <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-info btn-sm">
                                            Detail</a>
                                        <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-warning btn-sm">
                                            Edit</a>
                                        <form method="post" action="{{ route('purchases.destroy', $purchase->id) }}" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmSwalAlert(this)">
                                                Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $purchases->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
