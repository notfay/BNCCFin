<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-header h1 {
            margin-bottom: 5px;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-info div {
            width: 45%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>INVOICE</h1>
        <p>Invoice Number: {{ $invoice->invoice_number }}</p>
        <p>Date: {{ $invoice->created_at->format('d M Y H:i') }}</p>
    </div>
    
    <div class="invoice-info">
        <div>
            <h3>Customer Information:</h3>
            <p>
                <strong>Name:</strong> {{ $invoice->user->name }}<br>
                <strong>Email:</strong> {{ $invoice->user->email }}<br>
                <strong>Phone:</strong> {{ $invoice->user->phone }}
            </p>
        </div>
        
        <div>
            <h3>Shipping Information:</h3>
            <p>
                <strong>Address:</strong><br>
                {{ $invoice->shipping_address }}<br>
                <strong>Postal Code:</strong> {{ $invoice->postal_code }}
            </p>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->invoiceItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->product->category->name }}</td>
                <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Total:</td>
                <td>{{ $invoice->formatTotal() }}</td>
            </tr>
        </tfoot>
    </table>
    
    <div class="footer">
        <p>Thank you for your purchase!</p>
    </div>
    
    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print();" style="padding: 10px 20px; cursor: pointer;">Print Invoice</button>
        <button onclick="window.close();" style="padding: 10px 20px; margin-left: 10px; cursor: pointer;">Close</button>
    </div>
</body>
</html>