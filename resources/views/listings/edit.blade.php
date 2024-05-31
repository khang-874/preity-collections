<x-layout>
    <x-slot:navbar>
    </x-slot>

    <form action="/listings/{{$listing->id}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <x-form.field field="name" fieldName="Name" inputType="text" :value="$listing->name"> </x-form.field>
        <x-form.field field="description" fieldName="Description" inputType="text" :value="$listing->description"> </x-form.field>
        <x-form.field field="brand" fieldName="Brand" inputType="text" :value="$listing->brand"> </x-form.field>
        <x-form.field field="vendor" fieldName="Vendor" inputType="text" :value="$listing->vendor"> </x-form.field>
        <x-form.field field="initPrice" fieldName="Initial Price" inputType="number" :value="$listing->initPrice"> </x-form.field> 
    </form>
    @foreach ($listing->details as $detail)
        <form action="/details/{{$detail->id}}" class="bg-gray-500 mt-4 w-1/2">
            <x-form.field field="inventory" fieldName="Inventory" inputType="number" :value="$detail->inventory"> </x-form.field>
            <x-form.field field="sold" fieldName="Sold" inputType="number" :value="$detail->sold"> </x-form.field>
            <x-form.field field="weight" fieldName="Weight" inputType="number" :value="$detail->weight"> </x-form.field>
            <x-form.field field="size" fieldName="Size" inputType="text" :value="$detail->size"> </x-form.field>
            <x-form.field field="color" fieldName="Color" inputType="color" :value="$detail->color"> </x-form.field>
            <div class="flex ml-2 gap-2">
                @foreach ($detail->images as $image)
                    <img src="{{$image->imageURL}}" alt="" class="w-40">
                @endforeach
            </div>
        <button class="ml-2 p-2 bg-blue-600 mt-2 text-white rounded-sm">Update detail</button>
        </form>
    @endforeach
    <form action="/details" method="post">
        @csrf
        <button class="p-2 ml-2 bg-blue-600 mt-2 text-white rounded-sm">Add new detail</button>
    </form>
</x-layout>