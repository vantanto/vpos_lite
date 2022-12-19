@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Add Supplier</h1>
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Supplier</h3>
            </div>
            
            <div class="card-body">
                <form id="mainForm" method="post" action="{{ route('suppliers.store') }}" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name" class="required">Supplier Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter Supplier name" 
                                required>
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Supplier phone">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="Enter Supplier Address" rows="3"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" placeholder="Enter Supplier Description" rows="3"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <button type="submit" id="mainFormBtn" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>mainFormSubmit();</script>
@endsection
