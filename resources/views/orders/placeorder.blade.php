@props(["categories"])
<x-layout>

    <header>
        <x-navbar :categories="$categories"></x-navbar>
        <x-logo></x-logo>
    </header>
    <main>
        <div class='bg-white mt-2 mx-4 p-2 drop-shadow-md border-md'>
            <div class="font-medium text-lg">Order: </div>
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
                    localStorage.clear();
                    form.submit();
                }
            }" action="/orders" method="post" @submit.prevent="submitData">
                @csrf
                <x-form.field inputType="text" field="firstName" value="" fieldName="First name:"></x-form.field>
                <x-form.field inputType="text" field="lastName" value="" fieldName="Last name:"></x-form.field>
                <x-form.field inputType="tel" field="phoneNumber" value="" fieldName="Phone number:"></x-form.field>
        
                <div class="flex gap-3 flex-wrap mt-2">   
                    <template x-for="(item,index) in $store.cart.items" :key="index">
                            <div class="flex gap-x-2 border-2 p-1 relative w-11/12 mx-auto">
                                <img :src="item.imageURL" class="w-24 object-cover"alt="">
                                <div>
                                    <p x-text="item.name" class="font-medium"></p>    
                                    <p x-text="'Size: ' + item.size"></p>
                                    <p x-text="'Color: ' + item.color"></p>
                                    <p>Quantity: </p>
                                    <div class="flex items-center gap-2">
                                        <i @click="item.quantity++" class="fa-solid fa-plus"></i>
                                        <p x-text="item.quantity"></p>
                                        <i @click="() => {if(item.quantity > 1) item.quantity--;}" class="fa-solid fa-minus"></i>
                                    </div>
                                    <p x-text="'CA$ ' + item.price" class="font-semibold"></p>
                                    <button onsubmit="return false;" @click="$store.cart.removeFromCart(index)" class="absolute -top-1 -right-1 text-gray-500"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                    </template>
                </div>
                <template x-if="$store.cart.items.length != 0">
                    <div class="mx-auto w-fit text-lg font-medium">
                        <div x-text="'Subtotal: $' + $store.cart.getSubtotal().toFixed(2)"></div>
                    </div>
                </template>
                <x-button class="w-[80%] mx-[10%]">Place order</x-button>
            </form>
            <a href="/"><x-button class="w-[80%] mx-[10%]">Return to mainpage</x-button></a>
        </div>
    </main>
</x-layout>
