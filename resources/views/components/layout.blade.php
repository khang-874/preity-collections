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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

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
            getSubtotal(){
                subtotal = 0;
                for(let i = 0; i < this.items.length; ++i)
                    subtotal += this.items[i]['price'] * this.items[i]['quantity'];
                return subtotal;
            }
        });
        Alpine.store('showCart', {
            on: false,
            toggle(){
                this.on = !this.on;
            }
        });
        Alpine.store('showMenu', {
            on: false,
            toggle(){
                this.on = !this.on;
            }
        })
    })
    </script>

    @livewireStyles
</head>
<body class="mb-48 bg-gray-50">
    {{$slot}} 
 
    <x-flash-message></x-flash-message>
    @livewireScripts
</body>
</html>