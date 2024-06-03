@props(['customers'])

<x-layout>
    <main>
        @foreach($customers as $customer)
        <div class = 'm-2 bg-white drop-shadow-md p-2'>
           <div>First name: {{$customer -> firstName}}</div> 
           <div>Last name: {{$customer -> lastName}}</div>
           <div>Phone: {{$customer -> phoneNumber}}</div>
           <div>Amount owed: {{$customer -> amountOwed}}</div>
           <a href="/customers/{{$customer->id}}">Check all orders</a>
        </div>
        @endforeach
    </main>
</x-layout>