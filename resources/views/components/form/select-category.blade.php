@props(['categories', 'selectId' => 'category'])
<div class="flex flex-col">  
    <label for="category">Categories</label> 
    <select name="category" id="{{$selectId}}" x-ref="selectCategory" x-model="categoryId"
        {{-- Automatically choose the first option in section --}}
        x-on:change="() => {
            if($refs.selectSection && $refs.selectSection.options.length != 0)
                sectionId = $refs.selectSection.options[0].value
        }"
    >
        @foreach ($categories as $category)
            <option value="{{$category->id}}">{{$category -> name}}</option> 
        @endforeach
    </select>
</div>