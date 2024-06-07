@props(['categories', 'selectId' => 'section'])
<div class="flex flex-col">  
    <label for="section">Sections:</label> 
    <select name="section" id="{{$selectId}}" x-model="sectionId">
        @foreach ($categories as $category)
            @foreach ($category -> sections as $section)
                <template x-if="categoryId == {{$section -> category_id}}">
                    <option value="{{$section->id}}">{{$section->name}}</option>
                </template>
            @endforeach
        @endforeach
    </select>
</div>
