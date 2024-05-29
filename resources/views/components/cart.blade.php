<div x-cloak x-show="on" class="fixed inset-0 z-10 bg-black bg-opacity-50 w-screen h-screen">
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