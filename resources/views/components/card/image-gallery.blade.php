@props(['listing', 'cover'])


@php
   $count = 0;
@endphp


<div x-data = "{activeSlide: 0}" class="relative w-full h-40 {{$cover}}">
   @foreach ($listing->details as $detail)
      @foreach ($detail->images as $image)
      <div x-show="activeSlide === {{$count++}}"
            {{$attributes->merge(['class' => 'h-40 flex items-center justify-center'])}}>
               <img x-cloak src='{{$image -> imageURL}}' class='object-cover h-full overflow-hidden'/>
      </div>   
      @endforeach 
   @endforeach

   <div class="flex absolute w-full top-1/2">
      <div class="flex items-center justify-start w-1/2 ">
            <button 
            class="bg-transparent font-bold hover:shadow-lg rounded-full w-8 h-8 mb-4"
            x-on:click="activeSlide = activeSlide === 0 ? {{$count - 1}}: activeSlide - 1">
            <
            </button>
      </div>
      <div class="flex items-center justify-end w-1/2">
            <button 
            class="bg-transparent font-bold hover:shadow rounded-full w-8 h-8 mb-4"
            x-on:click="activeSlide = activeSlide ===  {{$count - 1}} ? 0 : activeSlide + 1">
            >
            </button>
      </div>        
   </div>
</div>