
<x-layout>
    <x-logo></x-logo>
    @php
        $details = $order -> details;
    @endphp
    <main>
        <div class="lg:ml-[10%] text-xl font-medium mt-4">Order details:</div>
        <div class="bg-white lg:mx-[10%]">
            @foreach ($order -> listings as $index => $listing)
                <div class="border-2 p-2 bg-white m-2 drop-shadow-md flex items-center gap-2">
                    <img src="{{$details -> get($index) -> images -> first() -> imageURL}}" alt="" class="w-36">
                    <div class="">
                        <div>Name: {{$listing -> name}}</div> 
                        <div>Price: {{$listing -> selling_price}}</div> 
                        <div>Size: {{$details -> get($index) -> size}}</div>
                        <div>Color: {{$details -> get($index) -> color}}</div>
                    </div>
                </div>
            @endforeach 
        </div>
        <a href="/customers/{{$order -> customer_id}}" class="lg:ml-[10%]"><x-button>Return</x-button></a>
    </main>
</x-layout>
