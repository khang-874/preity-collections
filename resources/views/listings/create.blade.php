@props(['categories'])

<x-layout>
    <main>
        <form x-data="{
            categoryId:'{{$categories -> first() -> id}}',
            sectionId: '{{$categories -> first() -> sections -> first() -> id}}'
        }"

        action="/listings" method="post" enctype="multipart/form-data" class="py-6 px-6 mt-8 flex flex-col gap-4 w-[80%] bg-white mx-auto border-2" id="createForm">
            @csrf
            <div class="text-2xl font-semibold">Create new listing</div>
            <div class="flex flex-col gap-1">
                <label for="name">Name</label>
                <input type="text" name="name" class='border border-gray-600 rounded-md p-1'>
                @error('name')
                    <p class="text-red-500 mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="flex flex-col gap-1">
                <label for="description">Description</label>
                <textarea form="createForm" name="description" rows="6" class='p-2 border border-gray-600 resize rounded-md'> </textarea>
                @error('description')
                    <p class="text-red-500 mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="flex flex-col gap-1">
                <label for="brand">Brand</label>
                <input type="text" name="brand" class='border border-gray-600 rounded-md p-1'>
                @error('brand')
                    <p class="text-red-500 mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="flex flex-col gap-1">
                <label for="vendor">Vendor</label>
                <input type="text" name="vendor" class='border border-gray-600 rounded-md p-1'>
                @error('vendor')
                    <p class="text-red-500 mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="flex flex-col gap-1">
                <label for="initPrice">Initial price</label>
                <input type="number" step = "0.01" name="initPrice" class='border border-gray-600 rounded-md p-1'>
                @error('initPrice')
                    <p class="text-red-500 mt-1">{{$message}}</p>
                @enderror
            </div>
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
            <div class="flex flex-col gap-1">
                <button class="border p-2 bg-blue-500 w-full text-white rounded-md">Create new listing</button>
                <a href="/" class="w-full text-center bg-blue-500 border text-white p-2 rounded-md">Return to mainpage</a>
            </div>

            
        </form>
    </main>
</x-layout>