@push('styles')
<style>
    .table-receipt td, .table-receipt th {
        padding: 0.25rem 0;
    }
    .table tr.variant td, .table tr.variant th {
        padding: 0;
    }
    .table.table-separator {
        border-bottom: 1px dashed black;
        margin-bottom: 0.25em;
    }
</style>
@endpush
<div id="section-to-print" class="card" style="font-size: 14px;">
    <div class="card-header pb-0 border-bottom-0">
        <div class="text-center border-bottom pb-1 mb-1">
            <div>{{ Helper::settings('store-name') }}</div>
            <div>{{ Helper::settings('store-address') }}</div>
            <div>{{ Helper::settings('store-phone') }}</div>
        </div>
        <div class="d-flex justify-content-between border-bottom pb-1">
            <div>
                {{ date('d/m/y H:i', strtotime($order->date)) }}
                <br>
                {{ $order->code }}
            </div>
            <div>
                {{ $order->user->name }}
                @if($order->customer)
                <br>
                Customer : {{ $order->customer->name }}
                @endif
            </div>
        </div>
    </div>
    <div class="card-body pt-0">
        <table class="table table-borderless table-separator table-receipt">
            <colgroup>
                <col style="width: 25px;">
                <col style="width: 25px;">
                <col style="width: 150px;">
                <col style="width: 75px;">
                <col style="width: 75px;">
            </colgroup>
            <tbody>
                @foreach ($order->orderDetails as $orderDetail)
                    <tr>
                        <td>{{ $orderDetail->quantity }}x</td>
                        <td colspan="2">
                            {{ $orderDetail->product->name }} ({{ $orderDetail->unit->name }})
                        </td>
                        <td class="text-right">{{ Helper::numberFormatNoZeroes($orderDetail->price) }}</td>
                        <td class="text-right">{{ Helper::numberFormatNoZeroes($orderDetail->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class="table table-borderless table-separator table-receipt">
            <colgroup>
                <col style="width: 25px;">
                <col style="width: 25px;">
                <col style="width: 150px;">
                <col style="width: 75px;">
                <col style="width: 75px;">
            </colgroup>
            <tbody class="text-right">
                <tr>
                    <td colspan="3">SubTotal</td>
                    <td></td>
                    <td>{{ Helper::numberFormatNoZeroes($order->subtotal) }}</td>
                </tr>
                @if ($order->discount > 0)
                <tr>
                    <td colspan="3">Discount</td>
                    <td></td>
                    <td>-{{ Helper::numberFormatNoZeroes($order->discount) }}</td>
                </tr>
                @endif
                @if ($order->tax > 0)
                <tr>
                    <td colspan="3">Tax</td>
                    <td></td>
                    <td>{{ Helper::numberFormatNoZeroes($order->tax) }}</td>
                </tr>
                @endif
                @if ($order->additional_price > 0)
                <tr>
                    <td colspan="3">Additional Price</td>
                    <td></td>
                    <td>{{ Helper::numberFormatNoZeroes($order->additional_price) }}</td>
                </tr>
                @endif
            </tbody>
        </table>
        <table class="table table-borderless table-separator table-receipt">
            <colgroup>
                <col style="width: 25px;">
                <col style="width: 25px;">
                <col style="width: 150px;">
                <col style="width: 75px;">
                <col style="width: 75px;">
            </colgroup>
            <tbody class="text-right">
                <tr>
                    <th colspan="3">TOTAL</th>
                    <th></th>
                    <th>{{ Helper::numberFormatNoZeroes($order->total) }}</th>
                </tr>
                <tr>
                    <th colspan="3">PAY</th>
                    <th></th>
                    <th>{{ Helper::numberFormatNoZeroes($order->total_pay) }}</th>
                </tr>
                <tr>
                    <th colspan="3">CHANGE</th>
                    <th></th>
                    <th>{{ Helper::numberFormatNoZeroes($order->total_change) }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>