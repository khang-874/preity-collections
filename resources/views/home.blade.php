<x-layout :categories="$categories">
    @php
        $sections = [];
        foreach($categories as $category)
            $sections = array_merge($sections, $category -> sections -> all());    
    @endphp
    <div>
        <x-promotions :promotions="$promotions"></x-promotions>
        <div class="container mx-auto flex flex-col gap-4 mt-6">
            <livewire:slideshow :items="$categories->all()" type="category" title="Shop by category"/>
            <livewire:slideshow :items="$sections" type="section" title="Shop by section"/>
            <livewire:slideshow :items="$newArrival" type="listing" title="Shop new arrival"/>
        </div>
    </div>
</x-layout>