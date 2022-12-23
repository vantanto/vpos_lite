<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderStatementController extends Controller
{
    public function index(Request $request)
    {
        $dateStart = Carbon::now()->startOfMonth();
        $dateEnd = Carbon::now()->endOfMonth();
        
        if ($request->fmonth) {
            $dateStart = Carbon::parse($request->fmonth)->startOfMonth();
            $dateEnd = Carbon::parse($request->fmonth)->endOfMonth();
        }

        $orderStatements = Product::with('units')
            ->select('products.*')
            ->selectRaw('SUM(od.quantity_total) as sum_od_quantity_total')
            ->selectRaw('SUM(od.subtotal) as sum_subtotal_gross')
            ->selectRaw('SUM(od.subtotal_discount) as sum_subtotal_discount')
            ->selectRaw('SUM(od.total * '.(Helper::settings('tax-nominal') / 100).') as sum_subtotal_tax')
            ->selectRaw('SUM(od.total) as sum_subtotal_net')
            ->selectRaw('SUM(od.total - (od.stock_price * od.quantity_total)) as sum_subtotal_profit')
            ->join('order_details as od', 'od.product_id', 'products.id')
            ->join('orders as o', 'o.id', 'od.order_id')
            ->whereBetween('o.date', [$dateStart, $dateEnd])
            ->whereNull(['od.deleted_at', 'o.deleted_at'])
            ->groupBy('products.id')
            ->orderBy('products.name')
            ->get();

        $data = [
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
            'orderStatements' => $orderStatements,
        ];

        if ($request->export == "pdf") {
            $pdf = Pdf::loadView('order_statement.pdf', $data);
            return $pdf->download('Order Statement '.$dateStart->format('Y-m').'.pdf');
        } else {
            return view('order_statement.index', $data);
        }
    }
}
