@props(['categories'])

{{-- <div class="w-full bg-white px-[10%]">
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
</div> --}}
<div x-data x-cloak x-show="$store.showMenu.on" class="fixed inset-0 z-10 bg-black bg-opacity-50 w-screen h-screen">
    <div    x-show="$store.showMenu.on" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-100 -translate-x-1/2"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 -translate-x-1/2"        
            class="bg-white shadow-lg w-64 h-full rounded-sm mr-auto overflow-y-scroll pb-8"
            @click.outside="$store.showMenu.toggle()"> 
        <div class="p-2 text-lg font-medium flex gap-x-2 border-b-2 mb-2 justify-between">
            <p>Categories</p>
            <button @click="$store.showMenu.toggle()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @foreach($categories as $category) 
            <x-navbar-card showVariable="showSection" outsideDivStyle='p-2 border-2 rounded-sm' insideDivStyle='' link="/?category={{$category->id}}" name="{{$category -> name}}">
                    @foreach ($category -> sections as $section)
                        <x-navbar-card showVariable="showSubsection" outsideDivStyle='border-t-2 py-2 pl-4' insideDivStyle='flex flex-col' link="/?section={{$section->id}}" name="{{$section->name}}">
                            @foreach($section -> subsections as $subsection)
                                <a class="w-full pl-2 py-1 border-t-2"href="/?subsection={{$subsection->id}}">{{$subsection -> name}}</a>
                            @endforeach
                        </x-navbar-card>
                    @endforeach
            </x-navbar-card>
        @endforeach 
    </div> 
</div>