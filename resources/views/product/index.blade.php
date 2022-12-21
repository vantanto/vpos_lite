@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Product List</h1>
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
        <div class="row">
            <div class="col-md-12">
                <form method="get" action="{{ request()->url() }}">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="search">Search</label>
                            <input type="text" id="search" name="search" class="form-control" placeholder="Code, Name"
                                value="{{ request()->input('search') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="category">Category</label>
                            <select id="category" name="category" class="form-control">
                                <option value="">All Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if($category->id == request()->input('category')) selected @endif>
                                    {{ $category->name }}
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
                    <div class="card-header d-flex">
                        <h3 class="card-title">Product List</h3>
                        <div class="ml-auto">
                            <a href="{{ route('products.create') }}" class="btn bg-purple">Add Product</a>    
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Stock Unit</th>
                                    <th>Sell Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration + $products->firstItem() - 1 }}.</td>
                                    <td>
                                        @if($product->is_show) 
                                        <span class="badge badge-success">Active</span> 
                                        @else
                                        <span class="badge badge-secondary">Deactive</span> 
                                        @endif
                                        &nbsp;
                                        {{ $product->code }}
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->stockString() }}</td>
                                    <td>{{ Helper::numberFormatNoZeroes($product->units[0]->sell_price) }}</td>
                                    <td>
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">
                                            Detail</a>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                            Edit</a>
                                        <form method="post" action="{{ route('products.destroy', $product->id) }}" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmSwalAlert(this)">
                                                Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
