@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Add Category</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Master Data</a></li>
        <li class="breadcrumb-item active">Category</li>
    </ol>
</div>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add Category</h3>
            </div>
            
            <div class="card-body">
                <form id="mainForm" method="post" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="required">Category Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter category name" 
                            required>
                        <span class="invalid-feedback"></span>
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
