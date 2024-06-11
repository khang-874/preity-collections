@props(['customers' , 'categories'])

<x-layout>
    <header>
        <x-logo></x-logo>
        <x-navbar :categories="$categories"></x-navbar>
    </header>
    <main>
        <form action="/customers/?unpaid=true" method="get"></form>
        <div class="md:mx-[10%]">
            @foreach($customers as $customer)
            <div class = 'm-2 bg-white drop-shadow-md p-2 flex items-center gap-4 hover:scale-[101%]'>
                <i class="fa-solid fa-user"></i>
                <div class='flex-grow'>
                    <div>Name: {{$customer -> firstName}} {{$customer -> lastName}}</div>
                    <div>Phone: {{$customer -> phoneNumber}}</div>
                    <div>Amount owed: {{$customer -> amountOwed}}</div>
                </div>
                <x-button><a href="/customers/{{$customer->id}}">History</a></x-button>
            </div>
            @endforeach
        </div>
    </main>
</x-layout>