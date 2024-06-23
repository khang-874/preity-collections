<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        *{
            margin: 0px;
            padding: 0px;
        }
        h1,h2,h3,h4,h5,h6{
            margin: 5px;
        }
    </style> 
    <script>
        window.onload = function(){
            window.print();
        }

    </script>
</head>
<body> 
    <div style='display:flex;flex-direction: column;'>
        @foreach($details as $detail)
            <div style="border-width: 1px; border-style:solid; width: 230px; margin:2px">
                <h1 style="word-wrap: wrap break-word; width:100%;">PREITY COLLECTION</h1>
                <h3>SN: {{$listing -> productId}}</h3>
                <h3>Price Code: {{$listing -> productPriceCode}}</h3>
                <h3>Size: {{$detail -> size}}</h3>
                <h3>Color: {{$detail -> color}}</h3>
                <h2>MRP: ${{$listing -> sellingPrice}}</h2>
                <h3>Made in India</h3>
                {{-- <div style="display:flex; justify-content:center;">@php echo $detail -> barcode @endphp</div> --}}
                <h3>Dry clean only</h3>
            </div>
        @endforeach
    </div>
</body>
</html>