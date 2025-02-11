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
            margin: 2px;
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
            <div style="width: 230px; height: 366px; break-after:page;">
                <h2>PREITY</h2>
				<h2>COLLECTION</h2>
                <h3>SN: {{$listing -> serial_number}}</h3>
                <h3>Price Code: {{$listing -> productPriceCode}}</h3>
                <h3>Size: {{$detail -> size}}</h3>
                <h3>Color: {{$detail -> color}}</h3>
                @if ($listing -> sale_percentage == 0)
                    <h2>MRP: ${{$listing -> basePrice}}</h2>
                @else 
                    <h3><s>ORG: ${{$listing -> basePrice}}</s></h3>
                    <h2>MRP: ${{$listing -> sellingPrice}}</h2>
                @endif
				<h3>Made in India</h3>
                <h3>Dry clean only</h3>
            </div>
        @endforeach
    </div>
</body>
</html>