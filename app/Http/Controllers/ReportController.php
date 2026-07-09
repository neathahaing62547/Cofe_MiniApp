<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index() {
        $reports = Report::latest('id')->get();

        $receipts = $reports
            ->groupBy('receipt_no')
            ->map(function ($items) {
                $firstItem = $items->first();

                return (object) [
                    'receipt_no' => $firstItem->receipt_no,
                    'customer_name' => $firstItem->customer_name,
                    'products' => $items,
                    'quantity' => $items->sum('quantity'),
                    'product_amount' => $items->sum('product_amount'),
                    'tax_amount' => $items->sum('tax_amount'),
                    'total_amount' => $items->sum('total_amount'),
                    'grand_total_amount' => $items->sum('grand_total_amount'),
                    'payment_method' => $firstItem->payment_method,
                    'status' => $firstItem->status,
                    'receipt_date' => $firstItem->receipt_date,
                    'created_at' => $firstItem->created_at,
                ];
            })
            ->values();
        return view('dashboard.report', compact('reports', 'receipts'));
    }

}
