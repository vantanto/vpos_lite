@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Setting List</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Setting</li>
    </ol>
</div>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        @if($method == "edit")
        <form id="mainForm" method="post" action="{{ route('settings.update') }}" autocomplete="off">
            @csrf
        @endif
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="d-flex justify-content-between">
                        @if($method == "index")
                            <a href="{{ route('settings.edit') }}" class="btn btn-warning mr-2">Edit Setting</a>
                            <form method="post" action="{{ route('settings.restore') }}" class="d-inline">
                                @csrf
                                <button type="button" class="btn btn-danger" onclick="confirmSwalAlert(this, 'Once restored, you will not be able to recover this setting!')">
                                    Restore Setting</button>
                            </form>
                        @elseif($method == "edit")
                            <button type="submit" id="mainFormBtn" class="btn btn-primary mr-2">Submit</button>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Store Setting</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>Store infomation used on <strong>order receipt</strong></p>
                            <div class="form-group row">
                                <label for="store-name" class="col-sm-4 col-form-label">Store Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="store-name" name="store-name"
                                        value="{{ $settings['store-name']->value }}" @if($method == "index") readonly @endif>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="store-address" class="col-sm-4 col-form-label">Store Address</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="store-address" name="store-address"
                                        value="{{ $settings['store-address']->value }}" @if($method == "index") readonly @endif>
                                        <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="store-phone" class="col-sm-4 col-form-label">Store Phone</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="store-phone" name="store-phone"
                                        value="{{ $settings['store-phone']->value }}" @if($method == "index") readonly @endif>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tax-nominal" class="col-sm-4 col-form-label">Tax</label>
                                <div class="col-sm-6">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="tax-nominal" name="tax-nominal"
                                            value="{{ $settings['tax-nominal']->value }}" @if($method == "index") readonly @endif>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input type="hidden" name="tax-use" value="0">
                                    <input type="checkbox" name="tax-use" id="tax-use" data-toggle="toggle" data-style="ios"
                                        @if($settings['tax-use']->value == "1") checked @endif 
                                        value="1" @if($method == "index") readonly @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @if($method == "edit")
        </form>
        @endif
    </div>
</section>
@endsection
@section('script')
<script>mainFormSubmit();</script>
@endsection
