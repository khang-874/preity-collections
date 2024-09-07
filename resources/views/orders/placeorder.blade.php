@props(["categories"])
<x-layout>
    <header>
        <x-header :categories="$categories"></x-header>
    </header>
    <main>
        <div x-data="{
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
                    {{-- localStorage.clear(); --}}
                    form.submit();
                }
            }"  
            class='bg-white mx-4 p-2 pt-0 md:mx-[12%] md:grid gap-8 h-[80vh]'
            style="grid-template-columns: 1fr 1fr"
        >
            <div>
                <div class="font-semibold text-lg md:text-2xl">Order information: </div>
                <form action="/orders" method="post" @submit.prevent="submitData" class="text-sm md:text-base flex flex-col gap-2">
                    @csrf 
                    <input type="text" name="firstName" id="firstName" placeholder="First name" class="border border-gray-600 rounded-md p-1">
                    <input type="text" name="lastName" id="phoneNumber" placeholder="Last name" class="border border-gray-600 rounded-md p-1">
                    <input type="tel" name="phoneNumber" id="phoneNumber" placeholder="Phone number" class="border border-gray-600 rounded-md p-1">

                </form>
            </div>
            <div    class="border mt-2 p-2 grid h-[80vh]"
                    style="grid-template-rows: 1fr auto" 
                    >
                <div class="h-full overflow-y-scroll">
                    <div class="flex flex-col gap-3">   
                        <template x-for="(item,index) in $store.cart.items" :key="index">
                                <div class="flex gap-x-2 relative">
                                    <img :src="item.imageURL" class="w-24 object-cover"alt="">
                                    <div>
                                        <p x-text="item.name" class="font-medium"></p>    
                                        <p x-text="'Size: ' + item.size"></p>
                                        <p x-text="'Color: ' + item.color"></p>
                                        <p>Quantity: </p>
                                        <div class="flex items-center gap-2">
                                            <i @click="item.quantity++" class="fa-solid fa-plus cursor-pointer"></i>
                                            <p x-text="item.quantity"></p>
                                            <i @click="() => {
                                                if(item.quantity > 1)
                                                    item.quantity--;
                                                else
                                                    $store.cart.removeFromCart(index);
                                            }" class="fa-solid fa-minus cursor-pointer"></i>
                                        </div>
                                        <p x-text="'CA$ ' + item.price" class="font-semibold"></p>
                                        {{-- <button onsubmit="return false;" @click="$store.cart.removeFromCart(index)" class="absolute -top-1 -right-1 text-gray-500"><i class="fa-solid fa-trash"></i></button> --}}
                                    </div>
                                </div>
                        </template>
                    </div>
                </div>
                <template x-if="$store.cart.items.length != 0">
                    <div class="w-full text-lg font-medium border-t-2 mt-2">
                        <div class="text-center" x-text="'Subtotal: $' + $store.cart.getSubtotal().toFixed(2)"></div>
                        <div class="text-center" x-text="'HST: $' + ($store.cart.getSubtotal() * .13).toFixed(2)"></div>
                        <div class="text-center font-extrabold" x-text="'Total: $' + ($store.cart.getSubtotal() * 1.13).toFixed(2)"></div>
                    </div>
                </template>
                <x-button class="w-[80%] mx-[10%]">Check out</x-button>
                <a href="/"><x-button class="w-[80%] mx-[10%] mt-2">Return to mainpage</x-button></a>
            </div>
        </div>

    </main>
</x-layout>
