<div x-data x-cloak x-show="$store.showCart.on" class="fixed inset-0 z-20 bg-black bg-opacity-50 w-screen h-screen">
    <div    x-show="$store.showCart.on" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-100 translate-x-1/2"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 translate-x-1/2"        
            class="bg-white shadow-lg w-64 lg:w-[25%] h-full rounded-sm ml-auto overflow-y-scroll grid gap-y-1"
            style="grid-template-rows: auto 1fr auto;"
            @click.outside="$store.showCart.toggle()"> 
        <div class="p-2 h-16 md:h-20 text-lg text-white bg-primary font-medium flex gap-x-2 border-b-2 items-center">
            <button @click="$store.showCart.toggle()"><i class="fa-solid fa-xmark"></i></button>
            <p>Shopping cart</p>
        </div>
        <div class="flex flex-col overflow-y-scroll  gap-y-2 px-1 items-center">
            <template x-for="(item,index) in $store.cart.items" :key="index">
                <div class='w-full'>
                    <div x-data="{quantity: item.quantiyt}"class="flex gap-x-2 relative">
                        <img x-bind:src="`{{url('/')}}/public/storage/${item.imageURL}`" class="w-24 h-auto"alt="">
                        <div>
                            <p x-text="item.name" class="font-medium"></p>    
                            <p x-text="'Size: ' + item.size" class="text-sm"></p>
                            <p x-text="'Color: ' + item.color" class="text-sm"></p>
                            <div class="flex gap-2">
                                <p class="text-sm">Quantity: </p>
                                <div class="flex items-center gap-2">
                                    <button @click="item.quantity++" >
                                        <i class="fa-solid fa-plus fa-sm"></i>
                                    </button>
                                    <p x-text="item.quantity" class="text-sm"></p>
                                    <button @click="() => {
                                            if(item.quantity > 1) 
                                                item.quantity--; 
                                            else
                                                $store.cart.removeFromCart(index);
                                        }">
                                        <i class="fa-solid fa-minus fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <p x-text="'CA$ ' + item.price" class="font-semibold"></p>
                            {{-- <button @click="$store.cart.removeFromCart(index)" class="absolute -top-1 -right-1 text-gray-500"><i class="fa-solid fa-trash"></i></button> --}}
                        </div>
                    </div>
                </div>
            </template> 
        </div>
        <template x-if="$store.cart.items.length != 0">
            <div class="font-medium bottom-0 border-t-2 pb-2" 
                x-data="{submitData(event){
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
                }}">
                <div class="text-center" x-text="'Subtotal: $' + $store.cart.getSubtotal().toFixed(2)"></div>
                <div class="text-center" x-text="'HST: $' + ($store.cart.getSubtotal() * .13).toFixed(2)"></div>
                <div class="text-center font-extrabold" x-text="'Total: $' + ($store.cart.getSubtotal() * 1.13).toFixed(2)"></div>
                {{-- <div class="flex justify-center mt-1"><a href="/placeOrder"><x-button>Check out</x-button></a></div> --}}
                <form action="{{route('stripe.checkout')}}" method="post" @submit.prevent='submitData'>
                    @csrf
                    <div class="flex justify-center mt-1"><x-button>Check out</x-button></div>
                </form>
            </div>
        </template>
    </div> 
</div>