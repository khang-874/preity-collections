<x-layout>
    <x-header :categories="$categories"></x-header>
    @php
        $sections = [];
        foreach($categories as $category)
            $sections = array_merge($sections, $category -> sections -> all());    
    @endphp
    <main>
        <x-home-slideshow :items="$categories->all()" type="category" title="Shop by category"></x-home-slideshow>  
        <x-home-slideshow :items="$sections" type="section" title="Shop by section"></x-home-slideshow>   
        <x-home-slideshow :items="$newArrival" type="listing" title="Shop new arrival"></x-home-slideshow>  

    </main>
</x-layout>