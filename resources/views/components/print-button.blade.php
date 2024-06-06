@props(['details', 'buttonName', 'productId', 'productPriceCode', 'sellingPrice'])
@php
    $htmlString = "";
    foreach ($details as $detail){
            $htmlString .= "<div style='border-width: 1px; border-style:solid; width: 125px; margin: 2px'>";
            $htmlString .= "<h4 style='word-wrap: break-word; width: 100%;'>PREITY COLLECTION</h4>";
            $htmlString .= "<h6>SN: " . $productId . "</h6>";

            $htmlString  .= "<h6>Price Code: " . $productPriceCode . "</h6>";
            $htmlString  .= '<h6>Size: ' . $detail -> size . '</h6>';
            $htmlString  .= "<h6>Color: " . $detail -> color . "</h6>";
            $htmlString  .= "<h5>MPR: " . $sellingPrice . "</h5>";
            $htmlString  .= "<h6>Made in India</h6>";
            $htmlString  .= "<h6>Dry Clean Only</h6>";
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
                h4,h5,h6{
                    margin: 5px;
                }
            </style>
        </head>
        <body>
            <div style='display:flex;'>
                {{$htmlString}}    
            </div>
        </body>
    </html>
    `);
    a.document.close();
    a.print();
}">{{$buttonName}}</x-button>