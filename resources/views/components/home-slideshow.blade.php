@props(['items', 'type', 'title'])
<div class="w-max mx-auto overflow-hidden">
    <p class="font-semibold text-lg text-center w-full mb-2">{{$title}}:</p>
    @if(Browser::isMobile())
        <livewire:slideshow :items="$items" perShow="2" type="{{$type}}"/> 
    @else
        <livewire:slideshow :items="$items" perShow="4" type="{{$type}}"/> 
    @endif
</div>
