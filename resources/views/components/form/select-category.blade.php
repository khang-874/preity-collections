@props(['categories', 'selectId' => 'category'])
<div class="flex flex-col">  
    <label for="category">Categories</label> 
    <select name="category" id="{{$selectId}}" x-model="categoryId">
        @foreach ($categories as $category)
            <option value="{{$category->id}}">{{$category -> name}}</option> 
        @endforeach
    </select>
</div>