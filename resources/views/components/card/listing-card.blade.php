@props(['item', 'type'])

@php
    switch($type){
        case 'listing':
            $link = '/listings/' . $item -> id;
            break;
        
        case 'category':
            $link = '/listings?category=' . $item -> id;
            break; 

        case 'section':
            $link = '/listings?section=' . $item -> id;
            break;
        
        case 'subsection':
            $link = '/listings?subsection=' . $item -> id;
            break;
    }
    $titleStyle = $type == 'listing' ? '' : '!text-base text-center'
@endphp
<a class="cursor-pointer" href="{{$link}}" >
    <x-card class="relative">
        @php
            $showingImage = $item -> images[0] ?? '';
            if(Storage::exists($showingImage))
                $showingImage = Storage::url($showingImage);
        @endphp
        <div class="h-[75%] lg:h-[80%] overflow-hidden"><img src="{{$showingImage}}" alt="" class="h-full min-w-full object-scale-down object-center"></div>
        <p class="w-[95%] text-xs pt-1 text-nowrap overflow-hidden {{$titleStyle}}">{{$item->name}}</p>
        @if($type == 'listing')
            @if ($item -> sale_percentage != 0)
                <div class="">
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-medium text-red-500">CA$ {{$item->selling_price}}</p> 
                        <p class="text-xs font-medium line-through">CA$ {{$item->base_price}}</p> 
                    </div>
                    <p class="text-sm font-medium text-red-500">{{round($item->sale_percentage)}}% off</p> 
                </div>
            @else
                <p class="text-sm font-medium">CA$ {{$item->selling_price}}</p> 
            @endif
        @endif
    </x-card>
</a>