@props(['listings_number'])

@php
    $name = '';
    if(request('category'))
        $name= \App\Models\Category::find(request('category')) -> name;
    if(request('section'))
        $name= \App\Models\Section::find(request('section')) -> name;
    if(request('subsection'))
        $name = \App\Models\Subsection::find(request('subsection')) -> name;
    if(Route::currentRouteName() == 'listings.indexClearance')
        $name .= ' Clearance';
@endphp
<div class="w-full flex justify-center mb-2 flex-col items-center">  
    <p class="text-lg md:text-xl font-medium">{{$name}}</p> 
    <div class="w-full hidden md:block">
        <hr class="border-t-[1px] border-gray-400 mt-6 mb-2 w-full">
        <div class="w-full">
            <p class="text-sm">({{$listings_number}} products)</p>
        </diV>
        <hr class="border-t-[1px] border-gray-400 my-2 w-full">
    <div>
</div>
