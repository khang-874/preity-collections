@props(['categories'])

<x-layout>
    <main>
        <form x-data="{
            categoryId:'{{$categories -> first() -> id}}',
            sectionId: '{{$categories -> first() -> sections -> first() -> id}}',
            subsectionId: '{{$categories -> first() -> sections -> first() -> subsections -> first() -> id}}'
        }"

        action="/listings" method="post" enctype="multipart/form-data" class="py-6 px-6 mt-8 flex flex-col gap-4 w-[80%] bg-white mx-auto border-2" id="createForm">
            @csrf
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
                <label for="subsection">Sections</label> 
                <select name="subsection" id="subsection" x-model="subsectionId">
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
            <div class="flex flex-col gap-1">
                <x-button>Create new listing</x-button>
                <a href="/" class="w-full text-center bg-blue-600 border text-white p-2 rounded-md">Return to mainpage</a>
            </div>

            
        </form>
    </main>
</x-layout>