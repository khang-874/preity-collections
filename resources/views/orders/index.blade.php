@props(['orders'])

<x-layout> 
    @foreach ($orders as $order)
        <div class = "m-2 drop-shadow-md">
            <div>Customer's name: {{$order -> customer -> firstName}}</div>
            @foreach($order -> listings as $listing)
                <div>Listing name: {{$listing -> name}}</div>
            @endforeach
            <div>Subtotal : ${{$order -> subtotal}}</div>
            <div>Tax: ${{$order -> total - $order -> subtotal}}</div>
            <div>Total: ${{$order -> total}} </div>
        </div>
    @endforeach
</x-layout>