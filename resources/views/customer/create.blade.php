@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Customer</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Customer & Type</a></li>
                    <li class="breadcrumb-item active">Customer</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Customer</h3>
            </div>
            
            <div class="card-body">
                <form id="mainForm" method="post" action="{{ route('customers.store') }}" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name" class="required">Customer Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter Customer name" 
                                required>
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Customer phone">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="Enter Customer Address" rows="3"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" placeholder="Enter Customer Description" rows="3"></textarea>
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
<script src="{{ asset('assets/js/submitForm.js') }}"></script>
<script>mainFormSubmit();</script>
@endsection
