@props(['categories', 'selectId' => 'section'])
<div class="flex flex-col">  
    <label for="section">Sections:</label> 
    <select name="section" id="{{$selectId}}" x-ref="selectSection" x-model="sectionId"
        {{-- Automatically choose the first option in subsection --}}
        x-on:change="() => {
            if($refs.selectSubsection && $refs.selectSubsection.options.length != 0)
                subsectionId = $refs.selectSubsection.options[0].value
        }"
    >
        @foreach ($categories as $category)
            @foreach ($category -> sections as $section)
                @if($loop->first)
                    <template x-if="categoryId == {{$section -> category_id}}">
                        <option value="{{$section->id}}" >{{$section->name}}</option>
                    </template>
                @else
                    <template x-if="categoryId == {{$section -> category_id}}">
                        <option value="{{$section->id}}">{{$section->name}}</option>
                    </template>
                @endif
            @endforeach
        @endforeach
    </select>
</div>
