<div x-data="$store.cartComponent" 
    x-cloak 
    x-show="$store.showCart.on" 
    class="fixed inset-0 z-20 bg-black bg-opacity-50 w-screen h-screen">
    <div x-show="$store.showCart.on" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-100 translate-x-1/2"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 translate-x-1/2"        
         class="bg-white shadow-lg w-64 lg:w-[25%] h-full rounded-sm ml-auto overflow-y-scroll grid gap-y-1"
         style="grid-template-rows: auto 1fr auto;"
         @click.outside="$store.showCart.toggle()"> 
        <div class="p-2 h-12 lg:h-16 text-lg text-white bg-primary font-medium flex gap-x-2 border-b-2 items-center">
            <button @click="$store.showCart.toggle()"><i class="fa-solid fa-xmark"></i></button>
            <p>Shopping cart</p>
        </div>
        <div class="flex flex-col overflow-y-scroll gap-y-2 px-1 items-center">
            <template x-for="(item, index) in cartItems" :key="index">
                <div class="w-full">
                    <div class="flex gap-x-2 relative">
                        <img :src="item.imageURL" class="w-24 h-auto" alt="">
                        <div>
                            <p x-text="item.name" class="font-medium"></p>
                            <p x-text="'Size: ' + item.size" class="text-sm"></p>
                            <p x-text="'Color: ' + item.color" class="text-sm"></p>
                            <div class="flex gap-2">
                                <p class="text-sm">Quantity: </p>
                                <div class="flex items-center gap-2">
                                    <button @click="incrementQuantity(index)">
                                        <i class="fa-solid fa-plus fa-sm"></i>
                                    </button>
                                    <p x-text="item.quantity" class="text-sm"></p>
                                    <button @click="decrementQuantity(index)">
                                        <i class="fa-solid fa-minus fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <template x-if="item.salePercentage != 0">
                                <div class="flex flex-col items-start">
                                    <p  class="text-sm font-medium line-through"
                                        x-text="'CA$ ' + (item.basePrice * item.quantity).toFixed(2)"></p>  
                                    <div class="flex">
                                        <p  class="text-base font-medium text-red-500" 
                                            x-text="'CA$ ' + (item.sellingPrice * item.quantity).toFixed(2)"></p> 
                                        <p  class="hidden text-base font-medium text-red-500 md:block"
                                            x-text="'(' + item.salePercentage + ' % off)'"></p>
                                    </div>
                                </div> 
                            </template>
                            <template x-if="item.salePercentage == 0">
                                <p x-text="'CA$ ' + (item.sellingPrice * item.quantity).toFixed(2)" class="font-semibold"></p>
                            </template>
                        </div>
                    </div>
                </div>
            </template> 
        </div>
        <template x-if="cartItems.length > 0">
            <div class="font-medium bottom-0 border-t-2 pb-2">
                <div class="text-center" x-text="'Subtotal: $' + getSubtotal().toFixed(2)"></div>
                <div class="text-center" x-text="'HST: $' + (getSubtotal() * 0.13).toFixed(2)"></div>
                <div class="text-center font-extrabold" x-text="'Total: $' + (getSubtotal() * 1.13).toFixed(2)"></div>
                <div class="flex justify-center mt-1"><a href="/placeOrder"><x-button>Check out</x-button></a></div>
            </div>
        </template>
    </div> 
</div>
