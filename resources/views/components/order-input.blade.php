@props(['listing', 'sizes', 'colors'])

<div x-data="productDetails(
        {{json_encode($sizes)}},
        {{json_encode($colors)}},
        {{$listing->id}},
        '{{ $listing->name }}',
        {{$listing->base_price}},
        {{$listing->selling_price}},
        {{round($listing->sale_percentage)}},
        '{{ $listing->getDisplayImageAt(0)}}'
    )"
    class="container flex flex-col">
    <div class="mt-2">
        <p class="mb-1">Select size:</p>
        <div x-ref="sizeContainer" class="flex gap-2 flex-wrap ml-2">
            @foreach ($sizes as $size => $quantity)
                <div x-id="['size']" class="flex items-center ps-2 border-gray-200 rounded border relative">
                    <input type="radio" x-model="size" :id="$id('size')" value="{{ $size }}" @change="showAvailableOptions('size', 'color')"
                            class="text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">

                    <label :for="$id('size')" class="w-full p-2 text-sm font-sm">{{ $size }}</label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-2">
        <p class="mb-1">Select color:</p>
        <div x-ref="colorContainer" class="flex gap-2 flex-wrap ml-2">
            @foreach ($colors as $color => $quantity)
                <div x-id="['color']" class="flex items-center ps-2 border-gray-200 rounded border relative">
                    <input type="radio" x-model="color" :id="$id('color')" value="{{ $color }}" @change="showAvailableOptions('color', 'size')"
                            class="text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                    <label :for="$id('color')" class="w-full p-2 text-sm font-sm">{{ $color }}</label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex gap-2 basis-[100%] mt-2">
        <label for="quantity" class="">Quantity:</label>
        <div class="flex items-center">
            <button @click="quantity++" class="flex items-center"><i class="fa-solid fa-plus"></i></button>
            <input type="number" x-model.number="quantity" id="quantity" class="w-8 text-center" />
            <button @click="() => {if(quantity > 1)quantity--;}" class="flex items-center"><i class="fa-solid fa-minus"></i></button>
        </div>
    </div>

    <button @click="handleClick" class="p-2 mt-2 bg-primary rounded-md font-medium text-white gap-2 w-52 text-base flex items-center justify-center">
        <i class="fa-solid fa-cart-shopping"></i>
        <p>Add to cart</p>
    </button>
</div>
