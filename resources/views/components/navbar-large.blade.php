@props(['categories'])
<div class="hidden md:block w-full h-min bg-white md:z-10 border-b-[1px]">
    <ul class="flex flex-wrap items-center font-normal relative gap-x-10 z-10 px-[2%]">
        @foreach ($categories as $category)
            <li x-data="{openCategory:false}" 
                @mouseenter="openCategory=true" 
                @mouseleave="openCategory=false"
                class="py-2"
            >
                <a href="/?category={{$category -> id}}" class="text-base rounded-md" :class="openCategory ? 'font-semibold' : ''">{{$category -> name}}</a>
                <ul x-show="openCategory"
                    x-transition:enter="transition ease-out duration-500 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-cloak                
                    class="absolute flex left-0 mt-2 bg-black/70 text-white w-full gap-4 pt-1 pb-2" 
                    @mouseenter="openCategory = true"
                >
                    @foreach ($category -> sections as $section)
                        @if($loop -> first)
                            <div class="ml-[2%]">
                        @else
                            <div class="ml-8">
                        @endif
                            <li>
                                <a href="/?section={{$section -> id}}" class="text-sm rounded-md">{{$section -> name}}</a>
                                <ul class="pl-2">
                                        @foreach ($section -> subsections as $subsection)
                                            <li>
                                                <a href="/?subsection={{$subsection -> id}}" class="text-xs hover:underline-offset-2 hover:underline">{{$subsection -> name}}</a>
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