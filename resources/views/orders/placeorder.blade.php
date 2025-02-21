@props(["categories"])
<x-layout :categories="$categories">
    <div    x-data="{
                submitData(event){
                    let items = $store.cartComponent.cartItems;
                    let form = $refs.form;
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
            }"
        class="max-w-7xl mx-auto p-6"> 
        <!-- Main Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Order Form -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Order Information</h2>
                {{-- <form class="space-y-4">  --}}
                <form action="/orders/online" method="post" @submit.prevent="submitData" class="space-y-4" x-ref="form">
                    @csrf
                    <x-form.order label="First Name" name="firstName"></x-form.order>
                    <x-form.order label="Last Name" name="lastName"></x-form.order> 
                    <x-form.order type="tel" label="Phone Number" name="phoneNumber"></x-form.order>  
                    <x-form.order type="email" label="Email" name="email"></x-form.order>  
                    <x-form.order type="text" label="Address" name="address"></x-form.order>
                    <x-form.order type="text" label="Postal code" name="postalCode"></x-form.order>
                    <x-form.order type="text" label="City" name="city"></x-form.order>
                </form> 
            </div>

            <!-- Cart Summary -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Cart Summary</h2>
                <div class="flex  space-x-2 mb-4 flex-col gap-3 max-h-[18rem] overflow-y-auto" x-data=""> 
                    <template x-for="(item,index) in $store.cartComponent.cartItems" :key="index">
                            <div class="flex gap-x-2 relative items-center">
                                <img :src="item.imageURL" class="w-28 h-28 object-top object-cover"alt="">
                                <div>
                                    <p x-text="item.name" class="font-bold text-gray-800"></p>    
                                    <p x-text="'Size: ' + item.size  + ' | Color: ' + item.color" class="text-sm text-gray-600"></p>
                                    <div class="flex items-center gap-2">                                        
                                        <button @click="$store.cartComponent.incrementQuantity(index)">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                        <p x-text="item.quantity" class="text-sm"></p>
                                        <button @click="$store.cartComponent.decrementQuantity(index)">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
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
                        </template>
                </div>
                <hr class="my-4" />
                <div class="text-sm text-gray-600 space-y-1">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span x-text="'CA$ ' + $store.cartComponent.getSubtotal().toFixed(2)"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>HST:</span>
                        <span x-text="'CA$ ' + ($store.cartComponent.getSubtotal() * .13).toFixed(2)">CA$ 1.30</span>
                    </div>
                    <div class="flex justify-between font-bold text-gray-800">
                        <span>Total:</span>
                        <span x-text="'CA$ ' + ($store.cartComponent.getSubtotal() * 1.13).toFixed(2)"></span>
                    </div>
                </div>
                <div class="mt-4 space-y-2">
                    <x-button class="w-full py-2 rounded-md"><div @click="submitData">Check out</div></x-button>
                    <a  href="/"
                        class="w-full text-center block bg-gray-200 text-gray-800 py-2 rounded-md hover:bg-gray-300">
                    Return to Main Page
                    </a>
                </div>
            </div>
        </div> 
    </div>
</x-layout>