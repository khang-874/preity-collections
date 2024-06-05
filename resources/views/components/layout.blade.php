<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/favicon.ico" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <style>
    [x-cloak] { display: none !important; }
    </style>

    <title>Clothing shop</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
        Alpine.store('cart', {
            items: Alpine.$persist([]), 
            
            addToCart(product) { 
                this.items.push(product);
            },
            removeFromCart(index){
                this.items.splice(index, 1);
            },
            placeOrder(event){
                data = [];
                console.log(event);
                let formData = new FormData();
                for(let item of this.items)
                    formData.append('items', {
                        'listingId' : item['listingId'],
                        'detailId' : item['detailId'],
                        'quantity' : item['quantity'],
                    });
                console.log(formData.values().get());
                fetch('/orders', {
                    method: 'post',
                    //headers:{
                    //    'Content-Type' : 'application/json',
                    //}
                    body: formData,
                });
            }
        });
        Alpine.store('showCart', {
            on: false,
            toggle(){
                this.on = !this.on;
            }
        });
    })
    </script>

</head>
<body class="mb-48 bg-gray-50">
    {{$slot}} 
 
    <x-flash-message></x-flash-message>
</body>
</html>