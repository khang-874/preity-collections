<div class='w-full h-24 flex justify-between items-center px-[10%] bg-white drop-shadow-md'>
    <div class='flex items-center gap-3'>
        <button x-data @click="$store.showMenu.toggle()"><i class="fa-solid fa-bars fa-lg"></i></button>
        <a href="/" class="w-14 font-serif font-bold">
            Preity's Collection
        </a>
    </div>
    
    @auth 
        <div class="flex gap-2">
            <x-search></x-search>
            <form action="/logout" method="post">
                @csrf 
                <button><i class="fa-solid fa-arrow-right-from-bracket fa-lg"></i></button> 
            </form> 
        </div>
    @else 
        <ul class="flex gap-4 items-center">
            <li class="h-full"><x-search></x-search></li>
            <li>
                <button x-data class='flex flex-col justify-center w-1/5' @click="$store.showCart.on = true">
                    <i class="fa-solid fa-cart-shopping mx-auto"></i>
                </button>
            </li>
        </ul> 
    @endauth
</div>