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
    <x-form.container actionURL="/listings/{{$listing->id}}" categoryId="{{$category_id}}" sectionId="{{$section_id}}" subsectionId="{{$listing->subsection_id}}">
        @csrf
        @method('PUT')
        <div class="text-2xl font-semibold">Update listing</div>
        <x-form.field field="name" fieldName="Name" inputType="text" :value="$listing->name"> </x-form.field>
        <div class="flex flex-col gap-1">
            <label for="description">Description</label>
            <textarea form="form" name="description" rows="6" class='p-2 border border-gray-600 resize rounded-md'> {{$listing->description}} </textarea>
            @error('description')
                <p class="text-red-500 mt-1">{{$message}}</p>
            @enderror
        </div>
        <x-form.field field="brand" fieldName="Brand" inputType="text" :value="$listing->brand"> </x-form.field>
        <x-form.field field="vendor" fieldName="Vendor" inputType="text" :value="$listing->vendor"> </x-form.field>
        <x-form.field field="initPrice" fieldName="Initial Price" inputType="number" :value="$listing->initPrice"> </x-form.field> 
        <div class="flex flex-col">  
                <label for="category">Categories</label> 
                <select name="category" id="category" x-model="categoryId">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category -> name}}</option> 
                    @endforeach
                </select>
            </div>
            
             <div class="flex flex-col">  
                <label for="section">Sections</label> 
                <select name="section" id="section" x-model="sectionId">
                    @foreach ($categories as $category)
                        @foreach ($category -> sections as $section)
                            <template x-if="categoryId == {{$section -> category_id}}">
                                <option value="{{$section->id}}">{{$section->name}}</option>
                            </template>
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col">  
                <label for="subsection">Subsections</label> 
                <select name="subsection" id="subsection">
                    @foreach ($categories as $category)
                        @foreach ($category -> sections as $section)
                            @foreach ($section -> subsections as $subsection)
                                <template x-if="sectionId == {{$subsection -> section_id}}">
                                    <option value="{{$subsection->id}}">{{$subsection->name}}</option>
                                </template>   
                            @endforeach 
                        @endforeach
                    @endforeach
                </select>
            </div>
        <x-button>Update listing</x-button>
    </x-form.contaier>
    
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

    <div class="text-2xl font-medium mx-[10%] mt-6">Update details: </div>

    <div class="flex flex-col gap-4 items-center">
        @foreach ($listing->details as $detail)
            <div class="border-2 roudned-sm w-[80%] flex flex-wrap pb-4">
                <div class="w-full">
                    <x-form.container actionURL='/details/{{$detail->id}}'>
                            @csrf
                            @method('PUT')
                            <x-form.field field="inventory" fieldName="Inventory" inputType="number" :value="$detail->inventory"> </x-form.field>
                            <x-form.field field="sold" fieldName="Sold" inputType="number" :value="$detail->sold"> </x-form.field>
                            <x-form.field field="weight" fieldName="Weight" inputType="number" :value="$detail->weight"> </x-form.field>
                            <x-form.field field="size" fieldName="Size" inputType="text" :value="$detail->size"> </x-form.field>
                            <x-form.field field="color" fieldName="Color" inputType="color" :value="$detail->color"> </x-form.field>
                            <input name="images[]" type="file" multiple>
                            <div class="flex ml-2 gap-2 flex-wrap">
                                @foreach ($detail->images as $image)
                                    @php
                                        $imageURL = $image -> imageURL;
                                        if(is_file($imageURL))
                                            $imageURL = asset($imageURL); 
                                    @endphp
                                    <img src="{{$imageURL}}" alt="" class="w-40">
                                @endforeach
                            </div>
                        <x-button>Update detail</x-button>
                    </x-form.container>
                </div>
                <div class="flex flex-grow px-[10%] gap-4">
                <div class="">
                    <x-form.delete-button url="/details/{{$detail->id}}" name="Delete detail"/>
                </div>
                <div class="">
                    <x-print-button
                        :details="[$detail]"
                        productId="{{$listing -> product_id}}" 
                        productPriceCode="{{$listing -> product_price_code}}"
                        sellingPrice="{{$listing -> selling_price}}"
                        buttonName="Print tag" 
                    ></x-print-button> 
                </div>
                </div>
            </div>
        @endforeach
    </div>
    <form action="/details?listingId={{$listing->id}}" method="post" class="ml-[10%]">
        @csrf
        <x-button>Add new detail</x-button>
    </form>
</x-layout>