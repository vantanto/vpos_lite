@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Dashboard</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</div>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        @can('admin')
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ Helper::numberFormatNoZeroes($newOrder) }}</h3>
                        <p class="mb-0">New Order</p>
                        <small>Today</small>
                    </div>
                    <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ Helper::numberFormatNoZeroes($totalOrder) }}</h3>
                        <p class="mb-0">Total Order</p>
                        <small>Today</small>
                    </div>
                    <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ Helper::numberFormatNoZeroes($newPurchase) }}</h3>
                        <p class="mb-0">New Purchase</p>
                        <small>Today</small>
                    </div>
                    <div class="icon"><i class="fas fa-cart-plus"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ Helper::numberFormatNoZeroes($newCustomer) }}</h3>
                        <p class="mb-0">New Customer</p>
                        <small>This Month</small>
                    </div>
                    <div class="icon"><i class="fas fa-user"></i></div>
                </div>
            </div>
        </div>
        @endcan
    </div>
</section>
@endsection