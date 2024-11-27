@props(['categories'])
<div class="container">
    <ul class="flex items-center font-normal relative z-10"> 
        <x-navbar-large-menu :categories="$categories"></x-navbar-large-menu>
        <li class="py-4 px-2 xl:px-4 min-h-full w-max font-medium group/clearance hover:border-b-2 hover:border-b-purple-500">
            <a href="/listings/clearance/" class="font-medium">Clearance</a>
            <ul class="absolute hidden group-hover/clearance:flex left-0 top-full w-full bg-white" >
                <x-navbar-large-menu :categories="$categories" clearance="true"></x-navbar-large-menu>
            </ul> 
        </li>
    </ul>
</div>