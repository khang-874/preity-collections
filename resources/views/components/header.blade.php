@props(['categories'])

<header class="bg-[#ffffff] shadow-lg fixed top-0 z-50 text-black w-full">
    <div class="container mx-auto flex items-center">
        <div class="flex flex-1 items-center">
            <!-- Logo and Brand --> 
            <x-logo></x-logo>    
            <!-- Navigation -->
            <div class="hidden lg:block container">
                <x-navbar-large :categories="$categories"></x-navbar-large> 
            </div>
        </div>
        <!-- Search and Cart -->
        <div class="flex items-center space-x-4 flex-grow-0">
            <x-search></x-search> 
            <button x-data class='flex flex-col justify-center pr-2' @click="$store.showCart.toggle()">
                <i class="fa-solid fa-cart-shopping mx-auto"></i>
            </button> 
        </div>
    </div>
    <x-navbar :categories="$categories"></x-navbar>
    <x-cart></x-cart>
</header>