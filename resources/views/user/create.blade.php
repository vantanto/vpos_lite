@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Add User</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">User</li>
    </ol>
</div>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add User</h3>
            </div>
            
            <div class="card-body">
                <form id="mainForm" method="post" action="{{ route('users.store') }}" autocomplete="off">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name" class="required">Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" 
                                required>
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="username" class="required">Username</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Enter Username" 
                                required>
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email" class="required">Email</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Enter Email" 
                                required>
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password" class="required">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter password"
                                required>
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
