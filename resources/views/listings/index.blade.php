<x-layout>
    <x-logo></x-logo>
    <x-cart></x-cart>
    <x-navbar :categories="$categories"></x-navbar>
    <main>
        
        @php
            // dd($listings)
        @endphp
        <div class="mt-4 md:mx-[10%] flex"> 
            <div class="hidden lg:block lg:basis-2/12 lg:flex-grow bg-white shadow-md h-full mt-8">
                <div x-data="{show:false}" class="border-b-[1px] p-2">
                    <div class="flex justify-between items-center">
                        <p>SIZE</p>
                        <i @click="show = !show" class="fa-solid fa-plus"></i>
                    </div>
                    <div x-show="show" x-cloak class="flex flex-col">
                        <x-form.options type="size">
                            @foreach ($sizes as $size)
                                <div x-id="['size']">     
                                    <input type="radio" name="size" :id="$id('size')" @click="handleClick" value="{{$size -> size}}">
                                    <label :for="$id('size')">{{$size -> size}}</label>
                                </div>
                            @endforeach
                        </x-form.options>
                    </div>
                </div>

                <div x-data="{show:false}" class="border-b-[1px] p-2">
                    <div class="flex justify-between items-center">
                        <p>COLOR</p>
                        <i @click="show = !show" class="fa-solid fa-plus"></i>
                    </div>
                    <div x-show="show" x-cloak class="flex flex-col">
                        <x-form.options type="color">
                            @foreach ($colors as $color)
                                <div x-id="['color']">     
                                    <input type="radio" name="color" :id="$id('color')" @click="handleClick" value="{{$color -> color}}">
                                    <label :for="$id('color')">{{$color-> color}}</label>
                                </div>
                            @endforeach
                        </x-form.options>
                    </div>
                </div>
            </div>
            <div class="lg:w-10/12">
                <div class="w-full flex justify-center mb-2">
                    @if (request('category'))
                    @php
                        $categoryName= \App\Models\Category::find(request('category')) -> name
                    @endphp
                        <p class="text-lg font-medium">{{$categoryName}}</p>
                    @endif
                    @if (request('section'))
                    @php
                        $sectionName = \App\Models\Section::find(request('section')) -> name
                    @endphp
                        <p class="text-lg font-medium">{{$sectionName}}</p>
                    @endif
                    @if (request('subsection'))
                    @php
                        $subsectionName = \App\Models\Subsection::find(request('subsection')) -> name
                    @endphp
                        <p class="text-lg font-medium">{{$subsectionName}}</p>
                    @endif
                </div>
                <div class="flex flex-wrap gap-1 justify-center">
                    @unless(count($listings) == 0)
                    @foreach ($listings as $listing)
                        @if ($listing -> available == true)
                            <x-card.listing-card :listing="$listing"/>
                        @endif
                    @endforeach
                    @else
                        <p>No listings found </p>
                    @endunless
                </div>
            </div>
        </div>
        @if(method_exists($listings, "links")) 
            <div class="mt-6 p-4">{{$listings->links()}}</div>
        @endif
        
    </main>
</x-layout>