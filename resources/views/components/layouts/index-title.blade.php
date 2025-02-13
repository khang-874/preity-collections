@props(['listings_number', 'title', 'orders'])

<div class="w-full flex justify-center mb-2 flex-col items-center">  
    <div class="text-lg md:text-xl font-medium flex gap-1 items-end">
        <p>{{$title}}</p>
        <p class="font-normal text-base md:hidden"> ({{$listings_number}} products)</p>
    </div> 
    <div class="w-full hidden md:block">
        <hr class="border-t-[1px] border-gray-400 mt-6 mb-2 w-full">
        <div class="flex justify-between">
            <div class="w-full">
                <p class="text-sm pl-1">({{$listings_number}} products)</p>
            </div>
            <div class="gap-3 hidden md:flex text-sm pr-2">
                @foreach ($orders as $key => $value)
                    @if ($value['active'])
                        <a class="w-max text-cyan-500 relative" href="{{request() -> fullUrlWithoutQuery(['order'])}}">
                            {{$value['name']}}
                            <div class="w-0 h-0 
                                border-l-[6px] border-l-transparent
                                border-b-[7px] border-b-cyan-500
                                border-r-[6px] border-r-transparent absolute left-1/2 -translate-x-1/2">
                            </div> 
                        </a>
                    @else
                        <a class="w-max" href="{{request() -> fullUrlWithQuery(['order' => $key])}}">{{$value['name']}}</a>
                    @endif
                @endforeach
            </div>
        </div>
        <hr class="border-t-[1px] border-gray-400 my-2 w-full">
    </div>
</div>
