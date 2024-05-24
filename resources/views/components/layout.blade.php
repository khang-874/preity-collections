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
                alert('Add this product to cart: ' + product['listingId'] + ' ' + product['size'] + ' ' 
                + product['color'] + ' ' + product['quantity']
                + product['imageURL'])
                this.items.push(product);
            },
            removeFromCart(index){
                    console.log(this.items.splice(index, 1));
            }
        })
    })
    </script>


</head>
<body class="mb-48 bg-gray-100">
    <header x-data={on:false}>
        <nav class="w-full bg-white sticky">
            <div class="flex justify-between items-center w-full h-24 px-[10%]">
                <a href="/" class="h-full flex items-center">
                    <img class="h-4/5" src={{asset('images/logo.png')}} alt="" class="logo"/>
                </a>
                <ul class="flex space-x-6 mr-6 text-lg h-full items-center">
                    <li class="h-full"><x-search></x-search></li>
                    <li>
                        <button class='flex flex-col justify-center w-1/5' @click=" on = true">
                            <i class="fa-solid fa-cart-shopping mx-auto"></i>
                            <p class="mx-auto">Cart</p>
                        </button>
                    </li>
                </ul> 
            </div>        
        </nav>

        <div x-cloak x-show="on" class="fixed inset-0 z-10 bg-black bg-opacity-50">
            <div    x-show="on" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-100 translate-x-1/2"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 translate-x-1/2"        
                    class="bg-white shadow-lg w-1/5 h-full roudned-sm ml-auto"
                    @click.outside="on = false"> 
                <template x-for="(item,index) in $store.cart.items" :key="index">
                <div class="border-2 border-red-600">
                    <p x-text="'Id of element ' + item.listingId"></p>
                    <img :src="item.imageURL" alt="">
                    <p x-text="item.color"></p>
                    <p x-text="item.size"></p>
                    <p x-text="item.quantity"></p>
                    <button @click="$store.cart.removeFromCart(index)" x-text="'Remove item' + index">Remove Item</button>
                </div>
                </template> 
            </div> 
        </div>

    </header>
    <main>
    {{-- View Output --}}
    {{$slot}}
    
    </main>
 
</body>
</html>