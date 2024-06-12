@props(['customer', 'categories'])

<x-layout>
    <header>
        <x-logo></x-logo>
        <x-navbar :categories="$categories"></x-navbar>
    </header>
    <main>
        <div class="lg:mx-[10%]">
            <div class="m-2 p-2 bg-white drop-shadow-md border-md">
                <div class="text-xl font-medium">Customer</div>
                <div>First name: {{$customer -> firstName}}</div>
                <div>Last name: {{$customer -> lastName}}</div>
                <div>Phone number: {{$customer -> phoneNumber}}</div>
                <div>Amount owed: {{$customer -> amountOwed}}</div>
                <form action="/customers/{{$customer->id}}" method="post">
                    @csrf
                    <div>
                        <label for="amountOwed">Amount owed: </label>
                        <input type="number" name="amountOwed" value="{{$customer -> amountOwed}}" id="amountOwed" class="border">
                        <x-button>Update amount owed</x-button>
                    </div>
                </form>
            </div>
            <div class="text-xl font-medium ml-4">Orders: </div>
            @foreach ($customer -> orders as $order)
                <div class="m-2 p-2 bg-white drop-shadow-md flex items-center hover:scale-[101%] gap-2 flex-wrap">
                    <div class="flex-grow">
                        <div>Date: {{$order -> created_at}}</div>
                        <div>Total: {{$order -> total}}</div>
                        <div>Payment: {{$order -> paymentType}}</div>
                    </div> 
                    <div><a href="/orders/{{$order -> id}}"><x-button>Check order</x-button></a></div>
                    @if ($order -> paymentType == 'pending')
                       <form action="/orders/{{$order->id}}" method="post" x-data>
                            @csrf
                            @method('put')
                            <div x-id="['amount']">
                                <label :for="$id('amount')">Amount pay:</label>
                                <input type="number" name="amount" :id="$id('amount')" class="border-2 rounded-md">
                            </div>
                            <div x-id="['paymentType']">
                                <label :for="$id('paymentType')">Payment Type:</label>
                                <select name="paymentType" :id="$id('paymentType')">
                                    <option value="credit">Credit card</option>
                                    <option value="debit">Debit card</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>
                            <x-button>Pay</x-button>
                       </form> 
                    @endif
                </div>
            @endforeach
            <a href="/customers" class="m-2"><x-button>Return</x-button></a>
        </div>
    </main>
</x-layout>