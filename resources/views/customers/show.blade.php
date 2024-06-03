@props(['customer'])

<x-layout>
    <main>
        <div>Showing customer</div>
        <div>First name: {{$customer -> firstName}}</div>
        <div>Last name: {{$customer -> lastName}}</div>
        <div>Phone number: {{$customer -> phoneNumber}}</div>
        <div>Amount owed: {{$customer -> amountOwed}}</div>
        <div>Orders: </div>
        @foreach ($customer -> orders as $order)
            <div class="m-2 p-2 bg-white drop-shadow-md">
                @foreach ($order -> listings as $listing)
                   <div>Name: {{$listing -> name}}</div> 
                   <div>Price: {{$listing -> selling_price}}</div>
                   
                @endforeach 
                <div>Total: {{$order -> total}}</div>
                <div>Payment: {{$order -> paymentType}}</div>
            </div>
        @endforeach
        <a href="/customers">Return</a>
    </main>
</x-layout>