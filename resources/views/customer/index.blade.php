@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Customer List</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Master Data</li>
        <li class="breadcrumb-item active">Customer</li>
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
                        <h3 class="card-title">Customer List</h3>
                        <div class="ml-auto">
                            <a href="{{ route('customers.create') }}" class="btn bg-purple">Add Customer</a>    
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
                                @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration + $customers->firstItem() - 1 }}.</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->description }}</td>
                                    <td>
                                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form method="post" action="{{ route('customers.destroy', $customer->id) }}" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmSwalAlert(this)">
                                                Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $customers->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
