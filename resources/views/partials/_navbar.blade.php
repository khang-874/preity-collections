<div class="w-3/4 mx-auto">
    @php
        $categoriesLen = sizeof($categories)
    @endphp
    <div class="grid grid-cols-{{$categoriesLen}} w-full" style="grid-template-rows: auto auto;">
    @foreach($categories as $category)
        <div class='peer/category{{$category->id}} row-start-1 bg-red-500 p-2'>
            <a href="/categories/{{$category->id}}" class="block"> Category: {{$category -> name}}</a> 
        </div> 
        <div class="hidden hover:inline-flex peer-hover/category{{$category->id}}:inline-flex gap-4 row-start-2 col-span-full w-full p-2">
            @foreach ($category->sections as $section)
            <div class="" >
                <a href="/sections/{{$section->id}}">Section: {{$section -> name}}</a>
                @foreach ($section->subsections as $subsection)
                    <div>
                        <a href="/subsections/{{$subsection->id}}">Subsection: {{$subsection->name}}</a> 
                    </div>
                @endforeach
            </div>
            @endforeach        
        </div>
    @endforeach
    </div>  
</div>