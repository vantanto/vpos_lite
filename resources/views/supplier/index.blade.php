@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Supplier List</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Master Data</a></li>
        <li class="breadcrumb-item active">Supplier</li>
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
                            <label for="search">Search</label>
                            <input type="text" id="search" name="search" class="form-control" placeholder="Name, Phone, Address"
                                value="{{ request()->input('search') }}">
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
                    <div class="card-header d-flex">
                        <h3 class="card-title">Supplier List</h3>
                        <div class="ml-auto">
                            <a href="{{ route('suppliers.create') }}" class="btn bg-purple">Add Supplier</a>    
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $loop->iteration + $suppliers->firstItem() - 1 }}.</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->address }}</td>
                                    <td>{{ $supplier->description }}</td>
                                    <td>
                                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form method="post" action="{{ route('suppliers.destroy', $supplier->id) }}" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmSwalAlert(this)">
                                                Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $suppliers->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
