@props(["categories"])
<x-layout>
    <x-navbar :categories="$categories"></x-navbar>
    <div>Your cart</div>
    <form x-data action="/orders" method="post" @submit.prevent="$store.cart.placeOrder($event)">
        @csrf
        <div><label for="firstName">First name</label><input type="text" class="border-2 m-2"></div>
        <div><label for="lastName">Last Name</label><input type="text" class="border-2 m-2"></div> 
        <div><label for="phoneNumber">Phone number</label><input type="tel" class="border-2 m-2"></div>
         
        <div>   
            <template x-for="(item,index) in $store.cart.items" :key="index">
                    <div class="flex gap-x-2 border-2 p-1">
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
        <x-button>Place order</x-button>
    </form>
</x-layout>
