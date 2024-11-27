@props(['listing', 'cover'])


@php
   $count = 0; 
@endphp


<div x-data = "{activeSlide: 0}" class="relative {{$cover}}">
   @foreach ($listing->images as $image)
      <div x-show="activeSlide === {{$count++}}"
               {{$attributes->merge(['class' => 'flex items-center justify-center'])}}> 
               <img x-cloak src='{{$listing -> getDisplayImageAt($count)}}' class='object-cover h-auto w-full object-top' style="max-height: 40rem;"/>
      </div>   
   @endforeach

   <div class="flex absolute w-full top-1/2">
      <div class="flex items-center justify-start w-1/2 ">
            <button 
            class="bg-black opacity-40 text-white font-medium hover:opacity-60 w-10 h-10"
            x-on:click="activeSlide = activeSlide === 0 ? {{$count - 1}}: activeSlide - 1">
            <
            </button>
      </div>
      <div class="flex items-center justify-end w-1/2">
            <button 
            class="bg-black opacity-40 text-white font-medium hover:opacity-60 w-10 h-10"
            x-on:click="activeSlide = activeSlide ===  {{$count - 1}} ? 0 : activeSlide + 1">
            >
            </button>
      </div>        
   </div>
</div>
