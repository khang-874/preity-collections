@props(["categories"])
<x-layout>
    <x-navbar :categories="$categories"></x-navbar>
    <div>Your cart</div>
    <form x-data="{
        submitData(event){
            let items = $store.cart.items;
            console.log(items);
            let form = event.target;
            let data = [];
            for(let i = 0; i < items.length; ++i){
                data.push({
                    'listingId': items[i]['listingId'],
                    'detailId' : items[i]['detailId'],
                    'quantity' : items[i]['quantity']
                })
                
            } 
            let inputField = document.createElement('input');
            inputField.type = 'hidden';
            inputField.name = 'items';
            inputField.value = JSON.stringify(data);
            form.appendChild(inputField);
            form.submit();
        }
    }" x-ref="orderForm" action="/orders" method="post" @submit.prevent="submitData">
        @csrf
        <div><label for="firstName">First name</label><input type="text" name="firstName" class="border-2 m-2"></div>
        <div><label for="lastName">Last Name</label><input type="text" name="lastName" class="border-2 m-2"></div> 
        <div><label for="phoneNumber">Phone number</label><input type="tel" name="phoneNumber" class="border-2 m-2"></div>
         
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
                            <button onsubmit="return false;"@click="$store.cart.removeFromCart(index)" class="bg-red-600 rounded-sm p-2 text-white">Remove</button>
                        </div>
                    </div>
            </template>
        </div>
        <x-button>Place order</x-button>
    </form>
    <a href="/"><x-button>Return to mainpage</x-button></a>
</x-layout>
