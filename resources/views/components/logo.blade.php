<div class='w-full h-24 flex justify-between items-center px-[10%] bg-white drop-shadow-md' x-data="{on:false}">
    <a href="/" class="w-14 font-serif font-bold">
        Preity's Collection
    </a>
    <ul class="flex gap-4 items-center">
        <li class="h-full"><x-search></x-search></li>
        <li>
            <button class='flex flex-col justify-center w-1/5' @click=" on = true">
                <i class="fa-solid fa-cart-shopping mx-auto"></i>
                <p class="mx-auto">Cart</p>
            </button>
        </li>
    </ul> 
   <x-cart></x-cart> 
</div>