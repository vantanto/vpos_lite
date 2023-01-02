@extends('layouts.app')
@section('content')
<section id="vue-container" class="content" v-cloak>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <label for="customer" class="mb-0">Customer </label>
                        <div class="row">
                            <div class="col-8">
                                <select id="customer" class="form-control" style="width: 100%;"
                                    v-model="order.customer.id">
                                    <option value="">{{ \App\Models\Customer::$default }}</option>
                                    <option v-for="(customer, indexCustomer) in customers" :key="`customer_${customer.id}`" :value="customer.id">
                                        @{{ customer.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <table class="table table-sm table-borderless m-0">
                            <tr>
                                <th>Sub Total</th>
                                <th class="text-right">@{{ numberFormatNoZeroes(order.subtotal) }}</th>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <th class="text-right">@{{ numberFormatNoZeroes(order.discount) }}</th>
                            </tr>
                            <tr v-if="tax_use == '1'">
                                <th>Tax</th>
                                <th class="text-right">@{{ numberFormatNoZeroes(order.tax) }}</th>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th class="text-right"><h3><b>@{{ numberFormatNoZeroes(order.total) }}</b></h3></th>
                            </tr>
                        </table>
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-submit-order"
                            :disabled="order.orderDetails.length < 1 || sendForm">
                            Pay Order
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form autocomplete="off"
                    v-on:submit.prevent="addOrderDetail">
                    <div class="row">
                        <div class="col-6 col-md-5">
                            <select id="product" class="form-control" style="width: 100%;"
                                required
                                v-model="currOrderDetail.product_id">
                                <option value="" disabled>Select Product</option>
                                <option v-for="product in products" :key="`product_${product.id}`" :value="product.id">
                                    @{{ product.name }} - @{{ numberFormatNoZeroes(product.units[0].sell_price) }}
                                </option>
                            </select>
                        </div>
                        <div class="col-6 col-md-4">
                            <select class="form-control" v-model="currOrderDetail.unit_id"
                                required>
                                <option value="" disabled hidden>Select Unit</option>
                                <option v-for="unit in currOrderDetail.units" :value="unit.id">@{{ unit.name }} - @{{ numberFormatNoZeroes(unit.sell_price) }}</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <input type="text" id="qty" class="form-control" placeholder="Qty" 
                                required inputmode="numeric"
                                :value="numberFormatNoZeroes(currOrderDetail.qty)"
                                v-on:input="event => currOrderDetail.qty = numberNoCommas(event.target.value)" >
                        </div>
                        <div class="col-6 col-md-1">
                            <button type="submit" class="btn btn-success btn-block">Add</button>
                        </div>
                    </div>
                </form>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-6 col-sm-5">Product</th>
                            <th class="col-6 col-sm-2">Price</th>
                            <th class="col-6 col-sm-2">Qty</th>
                            <th class="col-6 col-sm-2">Discount</th>
                            <th class="col-6 col-sm-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(orderDetail, indexOrderDetail) in order.orderDetails" :key="`orderdetail_${indexOrderDetail}`">
                            <td>@{{ orderDetail.product.name }} - @{{ orderDetail.unit.name }}</td>
                            <td>@{{ numberFormatNoZeroes(orderDetail.price) }}</td>
                            <td>
                                <input type="text" class="form-control form-control-sm" placeholder="Qty" 
                                    inputmode="numeric"
                                    :value="numberFormatNoZeroes(orderDetail.qty)"
                                    v-on:input="event => orderDetail.qty = numberNoCommas(event.target.value)">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" placeholder="Discount" 
                                    inputmode="numeric"
                                    :value="numberFormatNoZeroes(orderDetail.discount)"
                                    v-on:input="event => orderDetail.discount = numberNoCommas(event.target.value)">
                            </td>
                            <td class="text-right">
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    v-on:click="deleteOrderDetail(indexOrderDetail)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-submit-order">
        <div class="modal-dialog">
            <div class="modal-content">
                <form autocomplete="off"
                    v-on:submit.prevent="submitOrder">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title">Order Pay</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-6 col-form-label">Total</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control text-right" disabled
                                    :value="numberFormatNoZeroes(order_total)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-6 col-form-label">Cash</label>
                            <div class="col-sm-6">
                                <input type="text" id="order-pay" class="form-control text-right" data-type="thousand"
                                    :value="numberFormatNoZeroes(order.pay)"
                                    v-on:input="event => order.pay = numberNoCommas(event.target.value)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-6 col-form-label">Change</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control text-right" disabled
                                    :value="numberFormatNoZeroes(order_change)">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"
                            :disabled="sendForm">
                            Submit
                        </button>
                    </div>
                </form>
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
                customers: JSON.parse('@json($customers)'),
                products: JSON.parse('@json($products->keyBy("id"))'),
                tax_use: "{{ Helper::settings('tax-use') }}",
                tax_nominal: parseFloat("{{ Helper::settings('tax-nominal') }}"),
                sendForm : false,
                order: {
                    customer: {
                        id: '',
                    },
                    orderDetails: [],
                    subtotal: 0,
                    // additional: 0,
                    discount: 0,
                    tax: 0,
                    total: 0,
                    pay: '',
                    change: 0,
                },
                currOrderDetail: {
                    product_id: '',
                    units: [],
                    unit_id: '',
                    qty: '',
                },
            }
        },
        watch: {
            'order.orderDetails': {
                handler: function(after, before) {
                    vm.order.subtotal = 0;
                    vm.order.discount = 0;
                    vm.order.tax = 0;
                    vm.order.orderDetails.forEach(item => {
                        const order_detail_qty = parseInt(item.qty) || 0;
                        vm.order.subtotal += order_detail_qty * (parseFloat(item.price) || 0);
                        vm.order.discount += order_detail_qty * (parseFloat(item.discount) || 0);
                    });
                    if (vm.tax_use == '1') {
                        vm.order.tax = (vm.order.subtotal - vm.order.discount) * vm.tax_nominal / 100;
                    }
                },
                deep: true,
            }
        },
        computed: {
            'order_total': {
                get() {
                    const order_total = (parseFloat(this.order.subtotal) || 0) - (parseFloat(this.order.discount) || 0) + (parseFloat(this.order.tax) || 0);
                    this.order.total = order_total;
                    return order_total;
                }
            },
            'order_change' : {
                get() {
                    if (parseFloat(this.order.pay) > 0) {
                        const order_change = (parseFloat(this.order.pay) || 0) - (parseFloat(this.order.total) || 0);
                        this.order.change = order_change;
                        return order_change;
                    }
                }
            }
        },
        methods: {
            addOrderDetail() {
                // Check If Product & Unit Already Exists
                if (vm.order.orderDetails.find((item) => item.product_id == vm.currOrderDetail.product_id && item.unit_id == vm.currOrderDetail.unit_id)) {
                    alert('Product Already Exists!!');
                } else {
                    const product = vm.products[vm.currOrderDetail.product_id];
                    const unit = product.units.find((item) => item.id == vm.currOrderDetail.unit_id);
                    vm.order.orderDetails.push({
                        product_id: vm.currOrderDetail.product_id,
                        unit_id: vm.currOrderDetail.unit_id,
                        qty: vm.currOrderDetail.qty,
                        price: unit.sell_price,
                        discount: product.discount * unit.quantity,
    
                        product: product,
                        unit: unit,
                    });
                }
                vm.clearCurrOrderDetail();
            },

            deleteOrderDetail(indexOrderDetail) {
                vm.order.orderDetails.splice(indexOrderDetail, 1)
            },

            clearCurrOrderDetail() {
                vm.currOrderDetail = {
                    product_id: '',
                    units: [],
                    unit_id: '',
                    qty: '',
                };
                $("#product").val("").trigger("change");
            },

            // Function Order
            submitOrder() {
                vm.sendForm = true;
                $.ajax({
                    method: "post",
                    url: "{{ route('orders.store') }}",
                    data: JSON.stringify(vm.order),
                    contentType: "application/json",
                    success: function(data, textStatus, jqXHR) {
                        if (data.status == "success") {
                            window.location.href = "{{ route('receipts.show', '') }}" + `/${data.order_code}`;
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
            // Customer select2
            $("#customer").select2().on('change', function() {
                vm.order.customer.id = $(this).val();
            });

            // Product select2
            $("#product").select2({
                placeholder: "Select Product",
            }).on('change', function() {
                if ($(this).val()) {
                    vm.currOrderDetail.product_id = $(this).val();
                    vm.currOrderDetail.units = vm.products[vm.currOrderDetail.product_id].units;
                    vm.currOrderDetail.unit_id = vm.currOrderDetail.units[0].id;
                    setTimeout(function () { $("#qty").focus() }, 200);
                }
            });

            $('#modal-submit-order').on('shown.bs.modal', function() {
                setTimeout(function () { $("#order-pay").focus() }, 200);
            });
        },
    }).mount('#vue-container');
</script>
@endsection