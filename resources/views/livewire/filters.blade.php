<div x-data="{show:{{$currentOptions == [] ? 'false' : 'true'}}}" 
    class="p-4 {{$isBorder ? 'border-b-[1px] border-gray-200' : ''}} w-[15rem]">
    <div @click="show = !show" class="flex justify-between items-center cursor-pointer" :class="show ? 'mb-4' : ''">
        <p class="uppercase font-medium text-base">{{$property}}</p>
        <i x-cloak x-show="!show" class="fa-solid fa-plus"></i>
        <i x-cloak x-show="show" class="fa-solid fa-minus"></i>
    </div>
    <div    x-show="show"
            x-transition:enter="transition linear duration-500 transform"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition linear duration-0"
            x-transition:leave-start="opacity-0"
            x-transition:leave-end="opacity-0"
            x-cloak 
            class="flex flex-col">

            @foreach ($options as $option)
                <div x-id="['{{$property}}']" class="flex items-center gap-2">     
                    {{-- <input type="radio" name="size" :id="$id('{{$property}}')" @click="handleClick" value="{{$item}}"> --}}
                    <input type="checkbox" value="{{$option}}" wire:model.live="currentOptions" class="accent-black w-4 h-4 rounded-none">
                    <label :for="$id('{{$property}}')" class="capitalize">{{$option}}</label>
                </div>
            @endforeach
    </div>
</div>
