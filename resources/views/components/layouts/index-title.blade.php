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
<div class="w-full flex justify-center md:block mb-2">  
    <p class="text-lg font-medium">{{$name}}</p> 
</div>
