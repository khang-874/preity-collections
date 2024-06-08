@props(['categories'])

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
        @auth
            <a href="/listings/create" class=""><button class="p-2 border rounded-sm mb-2 w-full font-medium">Create new listing</button></a>
            <a href="/manage" class=""><button class="p-2 border rounded-sm mb-2 w-full font-medium">Manage categories</button></a>
            <a href="/customers" class=""><button class="p-2 border rounded-sm mb-2 w-full font-medium">Manage Customers</button></a>
        @endauth
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