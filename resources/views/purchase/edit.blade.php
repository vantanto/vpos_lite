@extends('layouts.app')
@section('header')
<div class="col-sm-6">
    <h1>Edit Purchase</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Purchase</li>
    </ol>
</div>
@endsection
@section('content')
<section id="vue-container" class="content" v-cloak>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form autocomplete="off"
                    v-on:submit.prevent="submitPurchase">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="date" class="required">Date</label>
                            <input type="date" id="date" class="form-control" 
                                required
                                v-model="purchase.date">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="supplier" class="required">Supplier</label>
                            <select id="supplier" class="form-control"
                                required
                                v-model="purchase.supplier_id">
                                <option value="" selected disabled>Choose Supplier</option>
                                @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">
                                    {{ $supplier->name }}
                                </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control" placeholder="Enter Purchase Description" rows="3"
                                v-model="purchase.description"></textarea>
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Total</label>
                            <input type="text" class="form-control" readonly
                                :value="numberFormatNoZeroes(purchase.total)"> 
                            <span class="invalid-feedback"></span>
                        </div>
                        <button type="submit" class="btn btn-primary"
                            :disabled="purchase.purchaseDetails.length < 1 || sendForm">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form autocomplete="off"
                    v-on:submit.prevent="addPurchaseDetail">
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <select id="product" class="form-control" style="width: 100%;"
                                required
                                v-model="currPurchaseDetail.product_id">
                                <option value="" disabled>Select Product</option>
                                <option v-for="product in products" :key="`product_${product.id}`" :value="product.id">
                                    @{{ product.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <select class="form-control" v-model="currPurchaseDetail.unit_id"
                                required>
                                <option value="" disabled hidden>Select Unit</option>
                                <option v-for="unit in currPurchaseDetail.units" :value="unit.id">@{{ unit.name }}</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <input type="text" class="form-control" placeholder="Qty" 
                                required inputmode="numeric"
                                :value="numberFormatNoZeroes(currPurchaseDetail.qty)"
                                v-on:input="event => currPurchaseDetail.qty = numberNoCommas(event.target.value)" >
                        </div>
                        <div class="col-6 col-md-2">
                            <input type="text" class="form-control" placeholder="Price" 
                                required inputmode="numeric"
                                :value="numberFormatNoZeroes(currPurchaseDetail.price)"
                                v-on:input="event => currPurchaseDetail.price = numberNoCommas(event.target.value)" >
                        </div>
                        <div class="col-6 col-md-2">
                            <button type="submit" class="btn btn-success btn-block">Add</button>
                        </div>
                    </div>
                </form>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-6 col-sm-5">Product</th>
                            <th class="col-6 col-sm-2">Qty</th>
                            <th class="col-6 col-sm-2">Price</th>
                            <th class="col-6 col-sm-2">Total</th>
                            <th class="col-6 col-sm-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(purchaseDetail, indexPurchaseDetail) in purchase.purchaseDetails" :key="`purchasedetail_${indexPurchaseDetail}`">
                            <td>@{{ purchaseDetail.product_name }} - @{{ purchaseDetail.unit_name }}</td>
                            <td>
                                <input type="text" class="form-control form-control-sm" placeholder="Qty" 
                                    inputmode="numeric"
                                    :value="numberFormatNoZeroes(purchaseDetail.qty)"
                                    v-on:input="event => { purchaseDetail.qty = numberNoCommas(event.target.value), calcPDTotal(purchaseDetail)}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" placeholder="Price" 
                                    inputmode="numeric"
                                    :value="numberFormatNoZeroes(purchaseDetail.price)"
                                    v-on:input="event => { purchaseDetail.price = numberNoCommas(event.target.value), calcPDTotal(purchaseDetail) }">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" placeholder="Price" 
                                    inputmode="numeric"
                                    :value="numberFormatNoZeroes(purchaseDetail.total)"
                                    v-on:input="event => { purchaseDetail.total = numberNoCommas(event.target.value), calcPDPrice(purchaseDetail) }">
                            </td>
                            <td class="text-right">
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    v-on:click="deletePurchaseDetail(indexPurchaseDetail)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
@if (config('app.debug'))
<script src="https://unpkg.com/vue@3.2.41/dist/vue.global.js"></script>
@else
<script src="https://unpkg.com/vue@3.2.41/dist/vue.global.prod.js"></script>
@endif
<script>
    const vm = Vue.createApp({
        data() {
            return {
                suppliers: JSON.parse('@json($suppliers)'),
                products: JSON.parse('@json($products->keyBy("id"))'),
                sendForm : false,
                purchase: {
                    supplier_id: '',
                    date: '{{ date("Y-m-d") }}',
                    subtotal: 0,
                    additional: 0,
                    discount: 0,
                    total: 0,
                    description: '',
                    purchaseDetails: [],
                    deletedPurchaseDetails: [],
                },
                currPurchaseDetail: {
                    product_id: '',
                    units: [],
                    unit_id: '',
                    qty: '',
                    price: '',
                },
            }
        },
        watch: {
            'purchase.purchaseDetails': {
                handler: function(after, before) {
                    vm.purchase.total = 0;
                    vm.purchase.purchaseDetails.forEach(item => {
                        const purchase_detail_qty = parseInt(item.qty) || 0;
                        vm.purchase.total += (item.qty * item.price) || 0;
                    });
                },
                deep: true,
            }
        },
        methods: {
            addPurchaseDetail() {
                // Check If Product & Unit Already Exists
                if (vm.purchase.purchaseDetails.find((item) => item.product_id == vm.currPurchaseDetail.product_id && item.unit_id == vm.currPurchaseDetail.unit_id)) {
                    alert('Product Already Exists!!');
                } else {
                    const product = vm.products[vm.currPurchaseDetail.product_id];
                    const unit = product.units.find((item) => item.id == vm.currPurchaseDetail.unit_id);
                    vm.purchase.purchaseDetails.push({
                        product_id: vm.currPurchaseDetail.product_id,
                        unit_id: vm.currPurchaseDetail.unit_id,
                        qty: vm.currPurchaseDetail.qty,
                        price: vm.currPurchaseDetail.price,
                        total: vm.currPurchaseDetail.qty * vm.currPurchaseDetail.price,
    
                        product_name: product.name,
                        unit_name: unit.name,
                    });
                }
                vm.clearCurrPurchaseDetail();
            },

            deletePurchaseDetail(indexPurchaseDetail) {
                if (vm.purchase.purchaseDetails[indexPurchaseDetail].id != undefined) {
                    vm.purchase.deletedPurchaseDetails.push(vm.purchase.purchaseDetails[indexPurchaseDetail].id);
                }
                vm.purchase.purchaseDetails.splice(indexPurchaseDetail, 1)
            },

            calcPDTotal(purchaseDetail) {
                purchaseDetail.total = (purchaseDetail.qty || 0) * (purchaseDetail.price || 0);
            },

            calcPDPrice(purchaseDetail) {
                purchaseDetail.price = (purchaseDetail.total || 0) / (purchaseDetail.qty || 0) || 0;
            },

            clearCurrPurchaseDetail() {
                vm.currPurchaseDetail = {
                    product_id: '',
                    units: [],
                    unit_id: '',
                    qty: '',
                    price: '',
                };
                $("#product").val("").trigger("change");
            },

            // Function Purcahse
            submitPurchase() {
                vm.sendForm = true;
                $.ajax({
                    method: "post",
                    url: "{{ route('purchases.update', $purchase->id) }}",
                    data: JSON.stringify(vm.purchase),
                    contentType: "application/json",
                    success: function(data, textStatus, jqXHR) {
                        if (data.status == "success") {
                            swalAlert('success', data.msg).then(() => {
                                window.location.href = $('meta[name="url-current"]').attr('content')
                            });
                        }
                    },
                    error: function(data, textStatus, jqXHR) {
                        if (typeof data.responseJSON !== 'undefined' && typeof data.responseJSON.status !== 'validator') {
                            swalAlert('error', 'Input Error!.');
                        } else {
                            swalAlert('error', data.responseJSON.msg ?? 'Error!');
                        }
                    },
                    complete: function(data, textStatus) {
                        vm.sendForm = false;
                    },
                });
            },

            numberFormatNoZeroes(x) {
                return numberFormatNoZeroes(x);
            },

            numberNoCommas(x) {
                return numberNoCommas(x);
            },
        },
        mounted() {
            var self = this;
            // Supplier select2
            $("#supplier").select2().on('change', function() {
                self.purchase.supplier_id = $(this).val();
            });

            // Product select2
            $("#product").select2({
                placeholder: "Select Product",
            }).on('change', function() {
                if ($(this).val()) {
                    self.currPurchaseDetail.product_id = $(this).val();
                    self.currPurchaseDetail.units = self.products[self.currPurchaseDetail.product_id].units;
                    self.currPurchaseDetail.unit_id = self.currPurchaseDetail.units[0].id;
                }
            });

            // ===== Set Default Value ==== //
            self.purchase.date = "{{ $purchase->date }}";
            self.purchase.supplier_id = "{{ $purchase->supplier_id }}";
            self.purchase.description = "{{ $purchase->description }}";
            self.purchase.subtotal = parseFloat("{{ $purchase->subtotal }}");
            self.purchase.additional = parseFloat("{{ $purchase->additional }}");
            self.purchase.discount = parseFloat("{{ $purchase->discount }}");
            self.purchase.total = parseFloat("{{ $purchase->total }}");

            @foreach ($purchase->purchaseDetails as $purchaseDetail)
            self.purchase.purchaseDetails.push({
                id: "{{ $purchaseDetail->id }}",
                product_id: "{{ $purchaseDetail->product_id }}",
                unit_id: "{{ $purchaseDetail->unit_id }}",
                qty: parseFloat("{{ $purchaseDetail->quantity }}"),
                price: parseFloat("{{ $purchaseDetail->price }}"),
                total: parseFloat("{{ $purchaseDetail->total }}"),

                product_name: "{{ $purchaseDetail->product->name }}",
                unit_name: "{{ $purchaseDetail->unit->name }}",
            })
            @endforeach

            $("#supplier").val(self.purchase.supplier_id).trigger("change");
            // ============================ //
        },
    }).mount('#vue-container');
</script>
@endsection
