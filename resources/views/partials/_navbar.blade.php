<div class="w-full bg-white px-[10%]">
    @php
        $categoriesLen = sizeof($categories)
    @endphp
    <div class="grid grid-cols-{{$categoriesLen}} w-full" style="grid-template-rows: auto auto;">
    @foreach($categories as $category)
        <div class='peer/category{{$category->id}} row-start-1 p-2'>
            <a href="/?category={{$category->id}}" class="block uppercase font-small"> {{$category -> name}}</a> 
        </div> 
        <div class="hidden hover:inline-flex peer-hover/category{{$category->id}}:inline-flex gap-4 row-start-2 col-span-full w-full p-2">
            @foreach ($category->sections as $section)
            <div class="" >
                <a href="/?section={{$section->id}}" class="font-small">{{$section -> name}}</a>
                <ul>
                @foreach ($section->subsections as $subsection)
                    <li>
                        <a href="/?subsection={{$subsection->id}}">{{$subsection->name}}</a> 
                    </li>
                @endforeach
                </ul>
            </div>
            @endforeach        
        </div>
    @endforeach
    </div>  
</div>