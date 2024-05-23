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
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        laravel: "#ef3b2d",
                    },
                },
            },
        }
    </script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v1.9.5/dist/alpine.js" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('storing', {
                cart: JSON.parse(localStorage.getItem('cart')) !== null ?  JSON.parse(localStorage.getItem('cart')) : [],
                addToCart(product) {
                    alert('Add this product id to cart: ' + product['listingId'] + ' with color: ' + 
                                product['color'] + ' and size ' + product['size']);
                    this.cart.push(product);
                    localStorage.setItem('cart', JSON.stringify(this.cart));
                    cart = JSON.parse(localStorage.getItem('cart'));
                }
            });
             Alpine.store('openCart', {
                on : false,
                toggle(){
                    this.on = !this.on;
                }
            });
        })
    </script>

    <style>
    [x-cloak] { display: none !important; }
    </style>

    {{-- <script src='./tailwind.config.js'></script> --}}
    <title>Clothing shop</title>
    @vite('resources/js/app.js')
</head>
<body class="mb-48 bg-gray-100">
    <nav class="w-full bg-white sticky">
        <div class="flex justify-between items-center w-full h-24 px-[10%]">
            <a href="/" class="h-full flex items-center"
                ><img class="h-4/5" src={{asset('images/logo.png')}} alt="" class="logo"
            /></a>
            <ul class="flex space-x-6 mr-6 text-lg h-full items-center">
                {{-- @auth
                    <li>
                        <span class="font-bold uppercase">Welcome {{auth() -> user() ->name}}</span>
                    </li>
                    <li>
                        <a href="/listings/manage" class="hover:text-laravel"
                            ><i class="fa-solid fa-gear"></i>
                            Manage Listings</a
                        >
                    </li>
                    <li>
                        <form class="inline" method="POST" action="/logout">
                            @csrf
                            <button type="submit">
                                <i class="fa-solid fa-door-closed"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li>
                        <a href="/register" class="hover:text-laravel"
                            ><i class="fa-solid fa-user-plus"></i> Register</a
                        >
                    </li>
                    <li>
                        <a href="/login" class="hover:text-laravel"
                            ><i class="fa-solid fa-arrow-right-to-bracket"></i>
                            Login</a
                        >
                    </li>
                @endauth --}}
                {{-- <li><a href="/listings/create" class='bg-red-400 p-4'>Create new listing</a></li> --}}
                <li class="h-full"><x-search></x-search></li>
                <li>
                    <button class='flex flex-col justify-center w-1/5' x-data @click="$store.openCart.toggle()">
                        <i class="fa-solid fa-cart-shopping mx-auto"></i>
                        <p class="mx-auto">Cart</p>
                     </button>
                    
                </li>
            </ul>
            
        </div>
        
    </nav>
    <div x-data x-cloak x-show="$store.openCart.on" class="fixed left-0 top-0 w-screen h-screen z-[1000] bg-black bg-opacity-50">
        <div    x-data x-transition.duration.200ms 
                x-show="$store.openCart.on" class="bg-white shadow-lg w-1/5 h-full roudned-sm ml-auto "
                @click.outside="$store.openCart.toggle()"
                >
                                    
                <template x-data x-for="item in $store.storing.cart" :key="item.listingId">
                <div>
                    <p x-text="'Id of element ' + item.listingId"></p>

                    <p x-text="item.color"></p>
                    <p x-text="item.size"></p>
                </div>
                </template> 
        </div> 
    </div>
    <main>
    {{-- View Output --}}
    {{-- <div x-show="$store.openCart.on" class="fixed right-0 top-0 h-full w-1/5"> This is a cart</div> --}}
    {{$slot}}
    
    </main>

    {{-- <footer class="fixed bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-white h-24 mt-24 opacity-90 md:justify-center">
        <p class="ml-2">Copyright &copy; 2022, All Rights reserved</p>

        <a
            href="/listings/create"
            class="absolute top-1/3 right-10 bg-black text-white py-2 px-5"
            >Post Job</a
        >
    </footer> --}}
</body>
</html>