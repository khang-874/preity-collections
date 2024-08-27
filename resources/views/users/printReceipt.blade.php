<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 320px; /* Adjust width to fit TM-T82 paper */
        }
        .center {
            text-align: center;
        }
        .left {
            text-align: left;
        }
        .right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        .separator {
            border-bottom: 1px solid #000;
            margin: 10px 0;
        }
        .total {
            font-weight: bold;
            font-size: 18px;
        }
        .item-separator {
            margin-top: 10px;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
        }
    </style>
</head>
<body>
    <div class="center bold">Preity Collection</div>
    <div class="center">548 Devonwood Circle</div>
    <div class="center">Gloucester, Ontario, K1T 4E5</div>
    <div class="center">Phone: (123) 456-7890</div>
    <div class="center">HST: #</div>

    <div class="separator"></div>

    <div class="left">Date: {{date('Y-m-d')}}</div>
    <div class="left">Time: {{date('H:i')}}</div>
    <div class="left">Receipt #: {{$order -> id}}</div>

    <div class="separator"></div>

    <table width="100%"> 
        <thead>
            <tr>
                <th class="left">Name</th>
                <th class="left">Serial Number</th>
                <th class="right">Quantity x Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order -> orderListings as $orderListing)
                <tr>
                    <td>{{$orderListing -> listing -> name}}</td>
                    <td>{{$orderListing -> listing -> serial_number}}</td>
                    <td class='right'>{{$orderListing -> quantity}} x ${{$orderListing -> listing -> sellingPrice}}</td>				
                </tr>
                @if (!$loop -> last)
                    <tr>
                        <td colspan="3" class="item-separator"></td>
                    </tr> 
                @endif 
            @endforeach
        </tbody>
    </table>

    <div class="separator"></div>

    <table width="100%">
        <tr>
            <td class="left bold">Subtotal:</td>
            <td class="right">${{$order -> subtotal}}</td>
        </tr>
        <tr>
            <td class="left bold">Tax (13%):</td>
            <td class="right">${{round($order -> subtotal * .13, 2)}}</td>
        </tr>
        <tr>
            <td class="left bold total">Total:</td>
            <td class="right total">${{$order -> total}}</td>
        </tr>
    </table>

    <div class="separator"></div>

    <div class="center">Thank you for your purchase!</div>
    <div class="center">Please come again!</div>
{{-- 
    <div class="separator"></div>

    <div class="center">Powered by Your Business</div> --}}
</body>
</html>
