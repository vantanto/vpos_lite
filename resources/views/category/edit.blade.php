@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Category</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Product & Category</a></li>
                    <li class="breadcrumb-item active">Category</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Category</h3>
            </div>
            
            <div class="card-body">
                <form id="mainForm" method="post" action="{{ route('categories.update', $category->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="required">Category Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter category name" 
                            value="{{ $category->name }}" required>
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
