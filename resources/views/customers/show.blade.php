@props(['customer', 'categories'])

<x-layout>
    <header>
        <x-logo></x-logo>
        <x-navbar :categories="$categories"></x-navbar>
    </header>
    <main>
        <div class="m-2 p-2 bg-white drop-shadow-md border-md">
            <div class="text-xl font-medium">Customer</div>
            <div>First name: {{$customer -> firstName}}</div>
            <div>Last name: {{$customer -> lastName}}</div>
            <div>Phone number: {{$customer -> phoneNumber}}</div>
            <form action="/customers/{{$customer->id}}" method="post">
                <div>
                    <label for="amountOwed">Amount owed: </label>
                    <input type="number" name="amountOwed" value="{{$customer -> amountOwed}}" id="amountOwed" class="border">
                    <x-button>Update amount owed</x-button>
                </div>
            </form>
        </div>
        <div class="text-xl font-medium ml-4">Orders: </div>
        @foreach ($customer -> orders as $order)
            <div class="m-2 p-2 bg-white drop-shadow-md flex">
                <div class="flex-grow">
                    <div>Date: {{$order -> created_at}}</div>
                    <div>Total: {{$order -> total}}</div>
                    <div>Payment: {{$order -> paymentType}}</div>
                </div>
                <div><a href="/orders/{{$order -> id}}"><x-button>Check order</x-button></a></div>
            </div>
        @endforeach
        <a href="/customers" class="m-2"><x-button>Return</x-button></a>
    </main>
</x-layout>