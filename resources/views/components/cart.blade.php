<div x-data x-cloak x-show="$store.showCart.on" class="fixed inset-0 z-10 bg-black bg-opacity-50 w-screen h-screen">
    <div    x-show="$store.showCart.on" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-100 translate-x-1/2"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 translate-x-1/2"        
            class="bg-white shadow-lg w-64 h-full rounded-sm ml-auto overflow-y-scroll pb-8"
            @click.outside="$store.showCart.toggle()"> 
        <div class="p-2 text-lg font-medium flex gap-x-2 border-b-2 mb-2">
            <button @click="$store.showCart.toggle()"><i class="fa-solid fa-xmark"></i></button>
            <p>Shopping cart</p>
        </div>
        <div class="flex flex-col gap-y-2 px-1">
        <template x-for="(item,index) in $store.cart.items" :key="index">
            <div x-data="{quantity: item.quantiyt}"class="flex gap-x-2 border-2 p-1">
                <img :src="item.imageURL" class="w-24 object-cover"alt="">
                <div>
                    <p x-text="item.name" class="font-medium"></p>    
                    <p x-text="'Size: ' + item.size"></p>
                    <p x-text="'Color: ' + item.color"></p>
                    <p x-text="'Quantity: ' + item.quantity"></p>
                    <p x-text="'CA$ ' + item.price" class="font-semibold"></p>
                    <button @click="$store.cart.removeFromCart(index)" class="bg-red-600 rounded-sm p-2 text-white">Remove</button>
                </div>
            </div>
        </template> 
        </div>
        <a href="/placeOrder"><x-button>Order</x-button></a>
    </div> 
</div>