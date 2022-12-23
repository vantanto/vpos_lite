<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseStatementController extends Controller
{
    public function index(Request $request)
    {
        $dateStart = Carbon::now()->startOfMonth();
        $dateEnd = Carbon::now()->endOfMonth();

        if ($request->fmonth) {
            $dateStart = Carbon::parse($request->fmonth)->startOfMonth();
            $dateEnd = Carbon::parse($request->fmonth)->endOfMonth();
        }

        $purchaseStatements = Product::with('units')
            ->select('products.*')
            ->selectRaw('SUM(pud.quantity_total) as sum_pud_quantity_total')
            ->selectRaw('SUM(pud.total) as sum_pud_total')
            ->join('purchase_details as pud', 'pud.product_id' ,'products.id')
            ->join('purchases as pu', 'pu.id', 'pud.purchase_id')
            ->whereNull(['pud.deleted_at', 'pu.deleted_at'])
            ->whereBetween('pu.date', [$dateStart, $dateEnd])
            ->groupBy('products.id')
            ->orderBy('products.name')
            ->get();

        $data = [
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
            'purchaseStatements' => $purchaseStatements,
        ];

        if ($request->export == "pdf") {
            $pdf = Pdf::loadView('purchase_statement.pdf', $data);
            return $pdf->download('Purchase Statement '.$dateStart->format('Y-m').'.pdf');
        } else {
            return view('purchase_statement.index', $data);
        }
    }
}
