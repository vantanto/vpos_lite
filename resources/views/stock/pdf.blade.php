<html>
<head>
    <style>
        table th, table td { padding: 0.25rem; }
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; font-size: 12px; }
    </style>
</head>
<body>
    <footer>Created : {{ date('d/m/Y H:i') }}</footer>
    <h3 style="text-align: center; margin-bottom: 0.5rem;">Stock Report</h3>
    <h4 style="text-align: center; margin: 0.5rem auto;">{{ $dateStart->format('d/m/Y') }} - {{ $dateEnd->format('d/m/Y') }}</h4>
    <br>
    <table border="1" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th>Product</th>
                <th>Stock In</th>
                <th>Stock Out</th>
                <th>Current Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productStocks as $productStock)
            <tr>
                <td>{{ $productStock->name }}</td>
                <td>{{ $productStock->stockString($productStock->sum_qty_total_in) }}</td>
                <td>{{ $productStock->stockString($productStock->sum_qty_total_out) }}</td>
                <td>{{ $productStock->stockString($productStock->stock - $productStock->sum_csf_qty_total_in + $productStock->sum_csf_qty_total_out) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>