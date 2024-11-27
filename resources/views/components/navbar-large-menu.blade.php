@props(['categories', 'clearance' => 'false'])

@foreach ($categories as $category)
<li class="py-4 px-2 xl:px-4 min-h-full w-max font-medium group/category hover:border-b-red-400 hover:border-b-2">
    <a href="/listings/{{$clearance == 'true' ? 'clearance/' : ''}}?category={{$category -> id}}" 
        class="text-base">{{$category -> name}}</a>
    <ul class="absolute group-hover/category:flex hidden left-0 top-full bg-white min-w-[80%]">
        @foreach ($category -> sections as $section) 
            <li class="p-3 w-max group/section hover:bg-gray-100 hover:border-b-2 hover:border-b-blue-300">
                <a href="/listings/{{$clearance == 'true' ? 'clearance/' : ''}}?section={{$section -> id}}" 
                    class="text-sm">{{$section -> name}}</a>
                <ul class="p-4 hidden group-hover/section:flex gap-2 group-hover/section:flex-wrap flex-col absolute left-0 top-full w-full bg-white min-h-[18rem] max-h-[20rem]"
                    style="max-height: 20rem;">
                    @foreach ($section -> subsections as $subsection)
                        <li class="flex group items-center text-xs gap-1 hover:text-red-400">
                            <a href="/listings/{{$clearance == 'true' ? 'clearance/' : ''}}?subsection={{$subsection -> id}}" 
                                >{{$subsection -> name}}</a>
                            <p class="group-hover:block hidden transition duration-300">></p>
                        </li> 
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
    {{-- <div class="fixed w-screen h-screen bg-black top-0 left-0 hidden peer-hover:block -z-10"></div> --}}
</li>
@endforeach
