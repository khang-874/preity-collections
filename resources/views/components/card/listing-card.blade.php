@props(['item'])

@php
    $sizes = [];
    foreach ($item -> details as $detail) {
        if($detail -> available && !array_key_exists($detail -> size, $sizes))
            $sizes[$detail -> size] = 1;
    }
@endphp

<a class="cursor-pointer" href="{{$item->link}}" >
    <div class="relative bg-white group w-36 sm:w-48 md:w-60">
        <div class="overflow-hidden relative"> 

            <img src="{{$item -> getDisplayImageAt(0)}}" alt="" class="w-full h-48 sm:h-64 md:h-80 object-cover object-top"> 
            @if($item -> sale_percentage != 0)
                <div class="absolute bg-red-400 z-10 bottom-1 left-0 text-xs p-1 text-white font-medium rounded-sm">Flat {{round($item -> sale_percentage)}}% OFF</div>
            @endif
        </div>
        <div class= "p-1">
        <p class="text-sm pt-1 text-nowrap overflow-hidden">{{$item->name}}</p>
            @if ($item -> sale_percentage != 0)
                <div class="flex items-center gap-1 sm:gap-2 sm:flex-row-reverse sm:justify-end">
                    <div class="flex">
                        <p class="text-base font-medium text-red-500">CA$ {{$item->selling_price}}</p> 
                        <p class="hidden text-base font-medium text-red-500 md:block">({{round($item->sale_percentage)}}% off)</p>
                    </div>
                    <p class="text-xs font-medium line-through">CA$ {{$item->base_price}}</p>  
                </div>
            @else
                <p class="text-sm font-medium">CA$ {{$item->selling_price}}</p> 
            @endif
        </div>

        <div class="absolute z-10 px-1 pb-2 bg-white group-hover:top-full w-full text-sm hidden group-hover:flex 
                    gap-2 items-center flex-wrap top-3/4 transition duration-100 ease-out">
            <p>Size:</p>
            @foreach ($sizes as $size => $tmp)
                <p class="border-[1px] rounded-md p-[2px]">{{$size}}</p>
            @endforeach
        </div>
    </div>
</a>