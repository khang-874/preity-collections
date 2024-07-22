@props(['showVariable', 'outsideDivStyle', 'link', 'name', 'insideDivStyle' => ''])
<div x-data="{ {{$showVariable}}:false}" class="flex mb-1 flex-col {{$outsideDivStyle}}">
    <div @click=" {{$showVariable}} = !{{$showVariable}}" class="flex justify-between items-center">
        <a href="{{$link}}" class="mr-auto w-max">{{$name}}</a>
        <div>
            <button >
                <i x-show="!{{$showVariable}}" class="fa-solid fa-plus"></i>
                <i x-show="{{$showVariable}}" class="fa-solid fa-minus"></i>
            </button>
        </div>
    </div>
    <div x-show="{{$showVariable}}" class='flex-grow {{$insideDivStyle}}'
        x-transition:enter="transition linear duration-400 transform"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition linear duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak 
    >
        {{$slot}}
    </div>
</div>