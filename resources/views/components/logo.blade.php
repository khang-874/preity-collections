<div class='w-full h-16 flex justify-between items-center px-[2%] bg-black text-white'>
    <div class='flex items-center gap-3'>
        <button x-data @click="$store.showMenu.toggle()" class="md:hidden"><i class="fa-solid fa-bars fa-lg"></i></button>
        <a href="/" class="w-max font-serif font-bold text-xl md:text-2xl flex gap-1 items-center">
            <img src="{{url('/')}}/images/logo.png" class="h-10 w-auto object-scale-down" alt="">
            <div class="w-min leading-none">Preity Collection</div> 
        </a>
    </div>
   
    {{-- {{$slot}} --}}
    
    <ul class="flex gap-4 items-center">
        <li class="h-full"><x-search></x-search></li>
        <li>
            <button x-data class='flex flex-col justify-center w-1/5' @click="$store.showCart.on = true">
                <i class="fa-solid fa-cart-shopping mx-auto"></i>
            </button>
        </li>
    </ul> 
</div>