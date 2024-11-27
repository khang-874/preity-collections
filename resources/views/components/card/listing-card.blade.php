@props(['item'])

<a class="cursor-pointer" href="{{$item->link}}" >
    <div class="relative transition duration-100 group">
        @php 
            $showingImage = $item -> images[0] ?? '';
            if(Storage::exists($showingImage))
                $showingImage = Storage::url($showingImage);
        @endphp
        <div class="overflow-hidden">
            @if ($item -> getDisplayImageAt(1) != '')
                <img src="{{$item -> getDisplayImageAt(0)}}" alt="" class="h-[20rem] w-full object-cover object-top group-hover:hidden"> 
                <img src="{{$item -> getDisplayImageAt(1)}}" alt="" class="hidden duration-200 scale-105 transition h-[20rem] w-full object-cover object-top group-hover:block"> 
            @else
                <img src="{{$item -> getDisplayImageAt(0)}}" alt="" class="h-[20rem] w-full object-cover object-top"> 
            @endif
        </div>
        <div class="bg-white p-1">
        <p class="w-[95%] text-base pt-1 text-nowrap overflow-hidden">{{$item->name}}</p>
            @if ($item -> sale_percentage != 0)
                <div class="">
                    <div class="flex items-center gap-2">
                        <p class="text-xs font-medium line-through">CA$ {{$item->base_price}}</p> 
                        <p class="text-sm font-medium text-red-500">CA$ {{$item->selling_price}} ({{round($item->sale_percentage)}}% off)</p> 
                    </div>
                </div>
            @else
                <p class="text-sm font-medium">CA$ {{$item->selling_price}}</p> 
            @endif
        </div>
    </div>
</a>