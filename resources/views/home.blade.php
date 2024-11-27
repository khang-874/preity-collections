<x-layout :categories="$categories">
    @php
        $sections = [];
        foreach($categories as $category)
            $sections = array_merge($sections, $category -> sections -> all());    
    @endphp
    <main>
        <x-promotions :promotions="$promotions"></x-promotions>
        <div class="md:max-w-[85%] mx-auto flex flex-col gap-4">
            <livewire:slideshow :items="$categories->all()" type="category" title="Shop by category"/>
            <livewire:slideshow :items="$sections" type="section" title="Shop by section"/>
            <livewire:slideshow :items="$newArrival" type="listing" title="Shop new arrival"/>
        </div>
    </main>
</x-layout>