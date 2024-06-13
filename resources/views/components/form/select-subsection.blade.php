@props(['categories', 'selectId' => 'subsection'])

<div class="flex flex-col">  
    <label for="subsection_id">Subsections:</label> 
    <select name="subsection_id" id="{{$selectId}}" x-model="subsectionId">
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
 