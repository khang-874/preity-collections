@props(['categories'])

<div x-data x-cloak x-show="$store.showMenu.on" class="fixed inset-0 z-10 bg-black bg-opacity-50 w-screen h-screen">
    <div    x-show="$store.showMenu.on" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-100 -translate-x-1/2"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 -translate-x-1/2"        
            class="bg-white shadow-lg w-64 lg:w-[25%] h-full rounded-sm mr-auto overflow-y-scroll pb-8"
            @click.outside="$store.showMenu.toggle()"> 
        <div class="p-2 text-xl text-white bg-black font-medium flex gap-x-2 border-b-2 mb-2 justify-between">
            <p>Categories</p>
            <button @click="$store.showMenu.toggle()"><i class="fa-solid fa-xmark"></i></button>
        </div> 
        <div class="px-1">
            @foreach($categories as $category) 
                <x-navbar-card showVariable="showSection" outsideDivStyle='text-lg' insideDivStyle='' link="/?category={{$category->id}}" name="{{$category -> name}}">
                        @foreach ($category -> sections as $section)
                            <x-navbar-card showVariable="showSubsection" outsideDivStyle='pl-1 text-base' insideDivStyle='flex flex-col' link="/?section={{$section->id}}" name="{{$section->name}}">
                                @foreach($section -> subsections as $subsection)
                                    <a class="w-full pl-1 text-sm"href="/?subsection={{$subsection->id}}">{{$subsection -> name}}</a>
                                @endforeach
                            </x-navbar-card>
                        @endforeach
                </x-navbar-card>
            @endforeach  

            {{-- showClearance --}}
            <x-navbar-card showVariable="showOnclearance" outsideDivStyle='text-lg' insideDiveStyle='' link='/?isClearance=true' name="Clearance">
                @foreach($categories as $category) 
                    <x-navbar-card showVariable="showSection" outsideDivStyle='pl-1 text-base' insideDivStyle='' link="/?category={{$category->id}}&isClearance=true" name="{{$category -> name}}">
                            @foreach ($category -> sections as $section)
                                <x-navbar-card showVariable="showSubsection" outsideDivStyle='pl-1 text-sm' insideDivStyle='flex flex-col' link="/?section={{$section->id}}&isClearance=true" name="{{$section->name}}">
                                    @foreach($section -> subsections as $subsection)
                                        <a class="w-full pl-1 text-xs"href="/?subsection={{$subsection->id}}&isClearance=true">{{$subsection -> name}}</a>
                                    @endforeach
                                </x-navbar-card>
                            @endforeach
                    </x-navbar-card>
                @endforeach 

            </x-navbar-card>
        </div>
    </div> 
</div>