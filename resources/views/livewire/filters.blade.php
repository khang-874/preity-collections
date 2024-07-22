<div x-data="{show:{{$currentOptions == [] ? 'false' : 'true'}}}" class="py-2">
    <div @click="show = !show" class="flex justify-between items-center cursor-pointer">
        <p class="uppercase font-medium text-sm">{{$property}}</p>
        <i x-show="!show" class="fa-solid fa-plus"></i>
        <i x-show="show" class="fa-solid fa-minus"></i>
    </div>
    <div    x-show="show"
            x-transition:enter="transition linear duration-400 transform"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak 
            class="grid grid-cols-2">
        {{-- <form> --}}
            @foreach ($options as $option)
                <div x-id="['{{$property}}']" class="flex items-center gap-2">     
                    {{-- <input type="radio" name="size" :id="$id('{{$property}}')" @click="handleClick" value="{{$item}}"> --}}
                    <input type="checkbox" value="{{$option}}" wire:model.live="currentOptions" class="accent-black w-4 h-4 rounded-none">
                    <label :for="$id('{{$property}}')" class="capitalize">{{$option}}</label>
                </div>
            @endforeach
        {{-- </form> --}}
    </div>
</div>
