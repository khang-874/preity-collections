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
    <div class="relative hover:scale-[101%] transition duration-200">
        @php
            // if($item && $item -> images)
            //     $showingImage = $item -> images[0];
            // else{
            //     if($item){
            //         if($type != 'listing')
            //             $showingImage = $item -> randomListing() -> images[0] ?? '';
            //         else 
            //             $showingImage = '';
            //     }else{
            //         $showingImage = '';
            //     }
            // }
            $showingImage = $item -> images[0] ?? '';
            if(Storage::exists($showingImage))
                $showingImage = Storage::url($showingImage);
        @endphp
        <div class=""><img src="{{$showingImage}}" alt="" class="h-[14rem] w-full object-cover object-center"></div>
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
    </div>
</a>