<html>
<head>
    <style>
        table th, table td { padding: 0.25rem; }
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; font-size: 12px; }
    </style>
</head>
<body>
    <footer>Created : {{ date('d/m/Y H:i') }}</footer>
    <h3 style="text-align: center; margin-bottom: 0.5rem;">Order Statement</h3>
    <h4 style="text-align: center; margin: 0.5rem auto;">{{ $dateStart->format('F Y') }}</h4>
    <br>
    <table border="1" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Gross Total</th>
                <th>Discount</th>
                @if (Helper::settings('tax-use'))
                <th>Tax</th>
                @endif
                <th>Net Total</th>
                <th>Profit Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderStatements as $orderStatement)                                    
            <tr>
                <td>{{ $orderStatement->name }}</td>
                <td>{{ $orderStatement->stockString($orderStatement->sum_od_quantity_total) }}</td>
                <td style="text-align: right;">{{ Helper::numberFormatNoZeroes($orderStatement->sum_subtotal_gross) }}</td>
                <td style="text-align: right;">{{ Helper::numberFormatNoZeroes($orderStatement->sum_subtotal_discount) }}</td>
                @if (Helper::settings('tax-use'))
                <td style="text-align: right;">{{ Helper::numberFormatNoZeroes($orderStatement->sum_subtotal_tax) }}</td>
                @endif
                <td style="text-align: right;">{{ Helper::numberFormatNoZeroes($orderStatement->sum_subtotal_net) }}</td>
                <td style="text-align: right;">{{ Helper::numberFormatNoZeroes($orderStatement->sum_subtotal_profit) }}</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="2">Total</th>
                <th style="text-align: right;">{{ Helper::numberFormatNoZeroes($orderStatements->sum('sum_subtotal_gross')) }}</th>
                <th style="text-align: right;">{{ Helper::numberFormatNoZeroes($orderStatements->sum('sum_subtotal_discount')) }}</th>
                @if (Helper::settings('tax-use'))
                <th style="text-align: right;">{{ Helper::numberFormatNoZeroes($orderStatements->sum('sum_subtotal_tax')) }}</th>
                @endif
                <th style="text-align: right;">{{ Helper::numberFormatNoZeroes($orderStatements->sum('sum_subtotal_net')) }}</th>
                <th style="text-align: right;">{{ Helper::numberFormatNoZeroes($orderStatements->sum('sum_subtotal_profit')) }}</th>
            </tr>
        </tbody>
    </table>
</body>
</html>