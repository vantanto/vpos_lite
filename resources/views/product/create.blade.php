@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Add Product</h1>
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
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Add Product</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a id="nav_tab_1" class="nav-link active" href="#tab_1" data-toggle="tab">Product</a></li>
                    <li class="nav-item"><a id="nav_tab_2" class="nav-link" href="#tab_2" data-toggle="tab">Unit</a></li>
                </ul>
            </div>
            
            <form id="mainForm" method="post" action="{{ route('products.store') }}" autocomplete="off">
                @csrf
                <div class="card-body">
                    <div class="tab-content clearfix">
                        {{-- Tab Product --}}
                        <div class="tab-pane active" id="tab_1">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="code">Product Code</label>
                                    <input type="text" id="code" name="code" class="form-control" placeholder="Enter product code" >
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name" class="required">Product Name</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter product name" 
                                        required>
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="sell_price" class="required">Sell Price</label>
                                    <input type="text" id="sell_price" name="sell_price" class="form-control" placeholder="Enter product sell price" 
                                        required data-type="thousand" inputmode="numeric">
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="unit" class="required">Unit</label>
                                    <input type="text" id="unit" name="unit" class="form-control" placeholder="Unit (gram/pcs)"
                                        required>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="form-check-inline">
                                        <input type="checkbox" id="is_show" name="is_show" class="form-check-input"
                                            checked
                                            value="1" >
                                        <label class="form-check-label" for="is_show">Show on Transaction</label>
                                        <span class="invalid-feedback"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="accordion">
                                <div id="collapseOne" class="collapse" data-parent="#accordion">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="category">Category</label>
                                            <select id="category" name="category" class="form-control">
                                                <option value="" selected disabled>Choose Category</option>
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="discount">Discount</label>
                                            <input type="text" id="discount" name="discount" class="form-control" placeholder="Discount"
                                                data-type="thousand" inputmode="numeric">
                                            <span class="invalid-feedback"></span>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="description">Description</label>
                                            <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                                            <span class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="card-title w-100">
                                    <a id="collapseOneBtn" href="#collapseOne" 
                                        data-toggle="collapse">
                                        Show More <i class="fas fa-angle-down fa-sm"></i>
                                    </a>
                                </h4>
                            </div>
                        </div>
                        {{-- Tab Unit --}}
                        <div class="tab-pane" id="tab_2">
                            <button type="button" class="btn btn-success mb-3 btn_add_unit">Add Unit</button> 
                            <table class="table">
                                <colgroup>
                                    <col class="col-4">
                                    <col class="col-3">
                                    <col class="col-3">
                                    <col class="col-2">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>Unit Name</th>
                                        <th>Quantity <span id="hun_quantity_title"></span></th>
                                        <th>Price Per Unit</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="body_add_unit">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="mainFormBtn" class="btn btn-primary btn-block">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>mainFormSubmit();</script>
<script>
    $('#collapseOne').on({
        'shown.bs.collapse': () => $("#collapseOneBtn").html('Show Less <i class="fas fa-angle-up fa-sm"></i>'),
        'hidden.bs.collapse': () => $("#collapseOneBtn").html('Show More <i class="fas fa-angle-down fa-sm"></i>')
    });
</script>

{{-- Script Unit --}}
<script>
    var unit_idx = 1;
    var unit_arrs = [];

    // Input Event for default Unit
    $(document).on('input', "#unit", function() {
        const el_val = $(this).val();
        $("#hun_quantity_title").html(" Per "+el_val);
    });

    // Input Event for placeholder Unit Price Placeholder
    $(document).on('input', ".un_name", function() {
        const el_val = $(this).val();
        const un_idx = $(this).data('idx');
        const un_id = $(this).data('id');
        unit_arrs[un_idx] = {
            "value": un_id ?? "un_"+un_idx,
            "name": el_val
        };
        $(this).closest(".un_parent").find(".un_price").attr("placeholder", "Price Per " + el_val);
    });

    // Calculate Price Per Unit
    $(document).on('change', ".un_qty", function() {
        const el = $(this);
        const un_idx = el.data('idx');
        const el_un_price = $("#un_price_"+un_idx);
        if (el_un_price.val() == "") {
            const un_price_per_uni = parseInt(numberNoCommas(el.val())) * parseInt(numberNoCommas($("#sell_price").val()));
            el_un_price.val(numberWithCommas(un_price_per_uni));
        }
    });

    // Append Unit
    $(document).on('click', '.btn_add_unit', function() {
        const body_add_unit = `
            <tr class="un_parent">
                <input type="hidden" name="unit_idx[]" value="`+unit_idx+`">
                <td>
                    <input type="text" id="un_name_`+unit_idx+`" name="un_name_`+unit_idx+`" class="form-control un_name"
                        data-idx="`+unit_idx+`">
                    <span class="invalid-feedback"></span>
                </td>
                <td>
                    <input type="text" id="un_qty_`+unit_idx+`" name="un_qty_`+unit_idx+`" class="form-control un_qty" placeholder="Quantity"
                        data-idx="`+unit_idx+`" data-type="thousand" data-decimal="0" inputmode="numeric">
                    <span class="invalid-feedback"></span>
                </td>
                <td>
                    <input type="text" id="un_price_`+unit_idx+`" name="un_price_`+unit_idx+`" class="form-control un_price" placeholder="Price"
                        data-idx="`+unit_idx+`" data-type="thousand" inputmode="numeric">
                    <span class="invalid-feedback"></span>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn_delete_unit"
                        data-idx="`+unit_idx+`">
                        <i class="fas fa-minus"></i>
                    </button>
                </td>
            </tr>`;
        $("#body_add_unit").append(body_add_unit);
        unit_idx++;
    });

    // Delete Unit
    $(document).on('click', '.btn_delete_unit', function() {
        const un_idx = $(this).data("idx");
        $(this).closest('.un_parent').remove();
        delete unit_arrs[un_idx];
    });
</script>
@endsection
