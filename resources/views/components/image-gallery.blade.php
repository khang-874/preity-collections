@props(['listing'])

@php
   $count = 0;
@endphp


<div x-data = "{activeSlide: 0}" class="relative">
   @foreach ($listing->details as $detail)
      @foreach ($detail->images as $image)
      <div x-show="activeSlide === {{$count++}}"
            {{$attributes->merge(['class' => 'h-48 flex items-center bg-teal-500 text-white rounded-lg'])}}>
               <img src='{{$image -> imageURL}}' class='w-full h-full'/>
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
