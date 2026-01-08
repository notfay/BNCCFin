<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceApiController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('user', 'items.product')->get();
        return response()->json([
            'success' => true,
            'data' => $invoices
        ]);
    }

    public function show($id)
    {
        $invoice = Invoice::with('user', 'items.product')->find($id);
        
        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $invoice
        ]);
    }
}
