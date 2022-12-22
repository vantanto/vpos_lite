<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockFlow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $dateStart = Carbon::now()->startOfDay();
        $dateEnd = Carbon::now()->endOfDay();
        $dateNow = Carbon::now()->endOfDay();
        if ($request->date_start && $request->date_end) {
            $dateStart = Carbon::parse($request->date_start)->startOfDay();
            $dateEnd = Carbon::parse($request->date_end)->endOfDay();
        }

        $stockFlows = StockFlow::whereBetween('date', [$dateStart, $dateEnd]);
        $currentStockFlows = StockFlow::where('date', '>', $dateEnd)->where('date', '<=', $dateNow);
        $productStocks = Product::with(['units'])
            ->select('products.*')
            ->selectRaw('SUM(IFNULL(stock_flows.quantity_total_in, 0)) as sum_qty_total_in')
            ->selectRaw('SUM(IFNULL(stock_flows.quantity_total_out, 0)) as sum_qty_total_out')
            ->selectRaw('SUM(IFNULL(csf.quantity_total_in, 0)) as sum_csf_qty_total_in')
            ->selectRaw('SUM(IFNULL(csf.quantity_total_out, 0)) as sum_csf_qty_total_out')
            ->leftJoinSub($stockFlows, 'stock_flows', function($join) {
                $join->on('stock_flows.product_id', 'products.id');
            })
            ->leftJoinSub($currentStockFlows, 'csf', function($join) {
                $join->on('csf.product_id', 'products.id');
            })
            ->orderBy('stock_flows.id', 'desc')
            ->orderBy('products.id')
            ->groupBy('products.id');
        
        if ($request->fproducts) {
            $productStocks->whereIn('products.id', $request->fproducts);
        }
        
        $data = [
            'productStocks' => $productStocks,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
        ];

        if ($request->export == "pdf") {
            $data['productStocks'] = $productStocks->get();
            $pdf = Pdf::loadView('stock.pdf', $data);
            return $pdf->download('Stock Report '.$dateStart->format('Y-m-d').'-'.$dateEnd->format('Y-m-d').'.pdf');
        } else {
            $data['productStocks'] = $productStocks->paginate(15);
            $data['products'] = Product::all();
            return view('stock.index', $data);
        }
    }
}
