@props(['showVariable', 'outsideDivStyle', 'link', 'name', 'insideDivStyle' => ''])
<div x-data="{ {{$showVariable}}:false}" class="flex mb-1 flex-col {{$outsideDivStyle}}">
    <div class="flex justify-between">
        <a href="{{$link}}" class="mr-auto w-max py-2">{{$name}}</a>
        <button @click=" {{$showVariable}} = !{{$showVariable}}"><i class="fa-solid fa-chevron-down"></i></button>
    </div>
    <div x-show="{{$showVariable}}" class='flex-grow {{$insideDivStyle}}'>
        {{$slot}}
    </div>
</div>