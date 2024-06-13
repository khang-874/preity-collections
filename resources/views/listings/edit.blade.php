@props(['listing', 'categories'])

<x-layout>
    <x-logo></x-logo>
    <x-navbar :categories="$categories"></x-navbar>
    @php
        $section_id = '';
        $category_id = '';
        foreach($categories as $category)
            foreach($category->sections as $section)
                foreach($section->subsections as $subsection)
                    if($subsection->id == $listing->subsection_id){
                        $section_id = $section->id;
                        $category_id = $category->id;
                        break 3;
                    }    
    @endphp
    <x-form.container   actionURL="/listings/{{$listing->id}}"
                        data="{ categoryId : '{{$category_id}}',
                                sectionId : '{{$section_id}}',
                                subsectionId : '{{$listing -> subsection_id}}',
                                initPrice: {{$listing -> initPrice}},
                                images: [],
                                
                        }"
                        class="bg-white rounded-md lg:mx[10%]"
                        formID="editForm"
                        >
        @method('PUT')
        <div class="text-2xl font-semibold lg:col-span-full">Product information:</div>
        <x-form.field field="name" fieldName="Product name" inputType="text" :value="$listing->name"> </x-form.field>
        <x-form.field field="initPrice" fieldName="Price(INR)" inputType="number" x-model="initPrice" step="any"></x-form.field> 
        <x-form.field field="weight" fieldName="Weight (KG)" inputType="number" :value="$listing -> weight" step="any"></x-form.field> 
        <div class="flex flex-col gap-1">
            <div>Selling price:</div>
            <div class="border rounded-md p-1 bg-white border-black">{{$listing -> selling_price}}</div>
        </div>

        <div class="flex flex-col gap-1">
            <div>Price code:</div>
            <div class="border rounded-md p-1 bg-white border-black">{{$listing -> product_price_code}}</div>
        </div>

        <div class="flex flex-col gap-1">
            <div>Inventory:</div>
            <div class="border rounded-md p-1 bg-white border-black">{{$listing -> stock}}</div>
        </div>

        <div class="flex flex-col">
            <label for="selectVendor">Vendor:</label>
            <select name="vendor_id" id="selectVendor" x-init="() => {$el.value = {{$listing -> vendor -> id}}}">
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
                <textarea form="editForm" name="description" rows="6" class='p-2 border border-gray-600 resize rounded-md'>{{$listing -> description}}</textarea>
                @error('description')
                    <p class="text-red-500 mt-1">{{$message}}</p>
                @enderror
            </div>

            <x-form.field field="images[]" fieldName="Choose images" inputType="file" multiple></x-form.field> 
            
        </div>
        <x-button class="lg:col-span-full">Update information</x-button>
    </x-form.contaier>
    <div class="text-lg font-medium">Images:</div>
    <div class="flex ml-2 gap-2 flex-wrap">
        @foreach ($listing->images as $image) 
            <div class="bg-white p-2 border flex flex-col items-center">
                <img src="{{$image -> imageURL}}" alt="" class="w-40">
                <form action="/images/{{$image ->id}}" method="post">
                    @csrf
                    @method('DELETE')
                    <x-button>Delete</x-button>
                </form>
            </div>
        @endforeach
    </div>
    
    <div>
        @foreach ($listing->details as $detail)
            <div>
                <div>Size : {{$detail -> size}}</div> 
                <div>Color : {{$detail -> color}}</div> 
                <div>Inventory : {{$detail -> inventory}}</div> 
                <div>Sold : {{$detail -> sold}}</div> 
            </div>
        @endforeach
    </div>
    <div class="mx-[10%] flex gap-x-4 flex-wrap">
        <a href="/listings/{{$listing->id}}"><x-button>Go to listing</x-button></a>
        <x-print-button :details="$listing -> details" 
                        productId="{{$listing -> product_id}}" 
                        productPriceCode="{{$listing -> product_price_code}}"
                        sellingPrice="{{$listing -> selling_price}}"
                        buttonName="Print all tag"
        ></x-print-button> 
        <x-form.delete-button url="/listings/{{$listing->id}}" name="Delete listing"/>
    </div>
 
</x-layout>