@props(['items', 'property'])

<div x-data="{show:false}" class="py-2">
    <div class="flex justify-between items-center">
        <p class="uppercase font-medium">{{$property}}</p>
        <i @click="show = !show" class="fa-solid fa-plus"></i>
    </div>
    <div x-show="show" x-cloak class="flex flex-col">
        <x-form.options type="{{$property}}">
            @foreach ($items as $item)
                <div x-id="['{{$property}}']">     
                    <input type="radio" name="size" :id="$id('{{$property}}')" @click="handleClick" value="{{$item}}">
                    <label :for="$id('{{$property}}')">{{$item}}</label>
                </div>
            @endforeach
        </x-form.options>
    </div>
</div>
