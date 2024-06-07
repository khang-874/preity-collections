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
            subsectionId: '{{$categories -> first() -> sections -> first() -> subsections -> first() -> id}}'
        }"
        actionURL="/listings" formID="createForm">
            <div class="text-2xl font-semibold">Create new listing</div>
            <x-form.field field="name" value="{{old('name')}}" fieldName="Name" inputType="text"></x-form.field> 
            <div class="flex flex-col gap-1">
                <label for="description">Description</label>
                <textarea form="createForm" name="description" rows="6" class='p-2 border border-gray-600 resize rounded-md'> </textarea>
                @error('description')
                    <p class="text-red-500 mt-1">{{$message}}</p>
                @enderror
            </div>
            
            <x-form.field field="brand" value="{{old('brand')}}" fieldName="Brand" inputType="text"></x-form.field> 
            <x-form.field field="vendor" value="{{old('vendor')}}" fieldName="Vendor" inputType="text"></x-form.field>  
            <x-form.field field="initPrice" value="{{old('initPrice')}}" fieldName="Initial price" inputType="number"></x-form.field>   
            
            <div class="flex flex-col gap-1">
                <x-button>Create new listing</x-button>
                <a href="/" class="w-full text-center bg-blue-600 border text-white p-2 rounded-md">Return to mainpage</a>
            </div>
 
            <x-form.select-category :categories="$categories"></x-form.select-category>
            <x-form.select-section :categories="$categories"></x-form.select-section>            
            <x-form.select-subsection :categories="$categories"></x-form.select-subsection>
           
        </x-form.container>
    </main>
</x-layout>