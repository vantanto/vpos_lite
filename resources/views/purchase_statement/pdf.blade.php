<html>
<head>
    <style>
        table th, table td { padding: 0.25rem; }
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; font-size: 12px; }
    </style>
</head>
<body>
    <footer>Created : {{ date('d/m/Y H:i') }}</footer>
    <h3 style="text-align: center; margin-bottom: 0.5rem;">Purchase Statement</h3>
    <h4 style="text-align: center; margin: 0.5rem auto;">{{ $dateStart->format('F Y') }}</h4>
    <br>
    <table border="1" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchaseStatements as $purchaseStatement)                                    
            <tr>
                <td>{{ $purchaseStatement->name }}</td>
                <td>{{ $purchaseStatement->stockString($purchaseStatement->sum_pud_quantity_total) }}</td>
                <td style="text-align: right;">{{ Helper::numberFormatNoZeroes($purchaseStatement->sum_pud_total) }}</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="2">Total</th>
                <th style="text-align: right;">{{ Helper::numberFormatNoZeroes($purchaseStatements->sum('sum_pud_total')) }}</th>
            </tr>
        </tbody>
    </table>
</body>
</html>