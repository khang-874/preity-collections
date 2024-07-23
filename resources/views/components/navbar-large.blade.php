@props(['categories'])
<div class="hidden md:block w-full h-min bg-white md:z-10 border-b-[1px]">
    <ul class="flex flex-wrap items-center font-normal relative gap-x-8 z-10 px-[2%]"> 
        <x-navbar-large-menu :categories="$categories"></x-navbar-large-menu>
        <li x-data="{showNavbarMenu:false}"
            @mouseenter="showNavbarMenu=true"
            @mouseleave="showNavbarMenu=false"
            class="py-2 text-base"
        >
            <a href="/listings/?isClearance=true" class="hover:font-semibold" :class="showNavbarMenu ? 'font-semibold' : ''">Clearance</a>
            <ul x-show="showNavbarMenu"
                class="absolute flex gap-x-8 px-[2%] left-0 mt-2 text-black bg-white border-y w-full gap-4 pt-1 pb-1" 
                x-cloak
            >
                <x-navbar-large-menu :categories="$categories" clearance="true"></x-navbar-large-menu>
            </ul>
        </li>
    </ul>
</div>