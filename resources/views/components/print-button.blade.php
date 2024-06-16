@props(['details', 'buttonName', 'productId', 'productPriceCode', 'sellingPrice'])
@php
    $htmlString = "";
    foreach ($details as $index=>$detail){
            $htmlString .= "<div style='border-width: 1px; border-style:solid; width: 230px; margin: 2px'>";
            $htmlString .= "<h1 style='word-wrap: break-word; width: 100%;'>PREITY COLLECTION</h1>";
            $htmlString .= "<h3>SN: " . $productId . "</h3>";

            $htmlString  .= "<h3>Price Code: " . $productPriceCode . "</h3>";
            $htmlString  .= '<h3>Size: ' . $detail -> size . '</h3>';
            $htmlString  .= "<h3>Color: " . $detail -> color . "</h3>";
            $htmlString  .= "<h2>MRP: $" . $sellingPrice . "</h2>";
            $htmlString  .= "<h3>Made in India</h3>";
            $htmlString  .= "<h3>Dry Clean Only</h3>";
            $htmlString  .= "<div style='display:flex; justify-content:center;'>" . $detail -> listing -> barcode . "</div>";
            $htmlString  .= "</div>";
    }
@endphp
<x-button x-data @click="() => {
    let a = window.open('', '',);
    a.document.write(`
    <html>
        <head>
            <style>
                *{
                    margin: 0px;
                    padding: 0px;
                }
                h1,h2,h3,h4,h5,h6{
                    margin: 5px;
                }
            </style> 
        </head>
        <body>
            <div style='display:flex;flex-direction: column;'>
                {{$htmlString}}    
            </div>
        </body>
    </html>
    `);
    a.document.close();
    a.print();
}">{{$buttonName}}</x-button>