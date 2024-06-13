@props(['categories'])

<x-layout>
    <header>
        <x-logo></x-logo>
        <x-navbar :categories="$categories"></x-navbar>
    </header>
    <main>
        <x-form.container data="{
            categoryId:'{{$categories -> first() -> id}}',
            sectionId: '{{$categories -> first() -> sections -> first() -> id}}',
            subsectionId: '{{$categories -> first() -> sections -> first() -> subsections -> first() -> id}}',
            initPrice : 0,
            showForm : false,
            details : [],
            getSellingPrice(){
                return Math.round(((this.initPrice / 55) * 2.5) / 5) * 5 - 0.01; 
            },
            getPriceCode(){
                let priceCode = '';
                let price = Math.round(this.initPrice / 5);
                let code = ['C', 'M', 'N', 'O', 'R', 'S', 'T', 'W', 'X', 'Y'];
                while(price > 0){
                    priceCode = code[price % 10] + priceCode;
                    price = Math.floor(price/10);
                }
                return priceCode;
            },
            createDetail(){
                this.showForm = true; 
            },
            closeForm(){
                this.showForm = false;
            },
            addNewDetail(size, color, inventory, sold){
                this.details.push({'size' : size, 'color' : color, 'inventory' : inventory, 'sold' : sold});
                this.showForm = false;
            },
            deleteDetail(index){
                this.details.splice(index, 1); 
            }
            ,
            handleSubmit(){
                let form = $el;
                let inputField = document.createElement('input');
                inputField.type = 'hidden';
                inputField.name = 'details';
                inputField.value = JSON.stringify(this.details);
                form.appendChild(inputField);
                form.submit();
            },
            getInventory(){
                let inventory = 0;
                for(let i=0; i < this.details.length; ++i)
                    inventory += parseInt(this.details[i]['inventory']);
                return inventory;  
            }
        }"
        actionURL="/listings" formID="createForm" @submit.prevent="handleSubmit"> 
            <div class="text-2xl font-semibold lg:col-span-full">Product information:</div>
            <x-form.field field="name" fieldName="Product name" inputType="text"> </x-form.field>
            <x-form.field field="initPrice" fieldName="Price(INR)" inputType="number" x-model="initPrice" step="any"></x-form.field> 
            <x-form.field field="weight" fieldName="Weight (KG)" inputType="number" step="any"></x-form.field> 
            <div class="flex flex-col gap-1">
                <div>Selling price:</div>
                <div class="border rounded-md p-1 bg-white border-black" x-text="getSellingPrice()"></div>
            </div>

            <div class="flex flex-col gap-1">
                <div>Price code:</div>
                <div class="border rounded-md p-1 bg-white border-black" x-text="getPriceCode()"></div>
            </div>

            <div class="flex flex-col gap-1">
                <div>Inventory:</div>
                <div class="border rounded-md p-1 bg-white border-black" x-text="getInventory()"></div>
            </div>

            <div class="flex flex-col">
                <label for="selectVendor">Vendor:</label>
                <select name="vendor_id" id="selectVendor">
                    @foreach ($vendors as $vendor)
                        <option value="{{$vendor -> id}}">{{$vendor -> name}}</option>
                    @endforeach 
                </select>
            </div>

            <x-form.select-category :categories="$categories"></x-form.select-category> 
            <x-form.select-section  :categories="$categories"></x-form.select-section>
            <x-form.select-subsection :categories="$categories"></x-form.select-subsection>

            <div class="lg:col-span-full">
                <div class="flex flex-col gap-1">
                    <label for="description">Description</label>
                    <textarea form="createForm" name="description" rows="6" class='p-2 border border-gray-600 resize rounded-md'></textarea>
                    @error('description')
                        <p class="text-red-500 mt-1">{{$message}}</p>
                    @enderror
                </div>

                <x-form.field field="images[]" fieldName="Choose images" inputType="file" multiple></x-form.field> 
            
            </div>
            <div>
                <div>
                    <div class="text-2xl font-medium">Product details</div>
                    <x-button type="button" @click="createDetail">Create detail</x-button>
                </div>
                <div x-cloak class="w-screen h-screen fixed bg-gray-400 bg-opacity-50 inset-0" x-show="showForm">
                    <div x-data="{
                        size: '', color: '', inventory:1, sold: 0, 
                        reset(){
                            this.size='';
                            this.color ='';
                            this.inventory = 1;
                            this.sold = 0;
                        }
                    }" class="bg-white mx-auto w-max mt-12">
                        <div>Add detail</div>
                        <x-form.field field='size' fieldName="Size: " inputType='text' x-model="size" divCss="!flex-row"></x-form.field> 
                        <x-form.field field='color' fieldName="Color: " inputType='text' x-model="color" divCss="!flex-row"></x-form.field> 
                        <x-form.field field='inventory' fieldName="Inventory: " inputType='number' x-model="inventory" divCss="!flex-row"></x-form.field> 
                        <x-form.field field='sold' fieldName="Sold: " inputType='number' x-model="sold" divCss="!flex-row"></x-form.field> 

                        <x-button type="button" @click="() => {closeForm(); reset()}">Close</x-button>
                        <x-button type="button" @click="() => {addNewDetail(size, color, inventory, sold, reset); reset()}" class="mx-auto">Add new detail</x-button>
                    </div>
                </div>
                <div>
                    <template x-for="(detail,index) in details">
                        <div>
                            <div x-text="'Size: ' + detail.size"></div>
                            <div x-text="'Color: ' + detail.color"></div>
                            <div x-text="'Inventory: ' + detail.inventory"></div>
                            <div x-text="'Sold: ' + detail.sold"></div>
                            <x-button type="button" @click="deleteDetail(index)">Delete</x-button>
                        </div>
                    </template>
                </div>
            </div>
            <x-button class="lg:col-span-full">Create product</x-button> 
        </x-form.container>
    </main>
</x-layout>