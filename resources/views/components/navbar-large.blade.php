@props(['categories'])
<div class="w-full h-min bg-white z-10 ">
    <ul class="flex flex-wrap items-center font-normal relative gap-x-8 z-10 px-[10%] pb-2">
        @foreach ($categories as $category)
            <li x-data="{openCategory:false}" 
                @mouseenter="openCategory=true" 
                @mouseleave="openCategory = false"
                class=""
            >
                <a href="/?category={{$category -> id}}" class="text-lg hover:bg-slate-300 p-1 rounded-md">{{$category -> name}}</a>
                <ul x-show="openCategory"
                    x-transition:enter="transition ease-out duration-400 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-400"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-cloak                
                    class="absolute flex left-0 mt-2 bg-white w-full gap-2 pb-4" 
                    @mouseenter="openCategory = true"
                >
                    @foreach ($category -> sections as $section)
                        @if($loop -> first)
                            <div class="ml-[10%]">
                        @else
                            <div class="ml-8">
                        @endif
                            <li>
                                <a href="/?section={{$section -> id}}" class="text-base hover:bg-slate-200 p-1 rounded-md">{{$section -> name}}</a>
                                <ul class="pl-2">
                                        @foreach ($section -> subsections as $subsection)
                                            <li>
                                                <a href="/?subsection={{$subsection -> id}}" class="text-sm hover:bg-slate-100 p-1 rounded-md">{{$subsection -> name}}</a>
                                            </li> 
                                        @endforeach
                                </ul>
                            </li>
                        </div>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</div>