@props(['listing'])

<x-layout>
    <a href="/listings/{{$listing->id}}"><x-button>Check listing</x-button></a>
    @php
        $printAllTag = "";
        foreach ($listing->details as $detail){
                $printAllTag .= "<div style='border-width: 1px; border-style:solid; width: 125px; margin: 2px'>";
                $printAllTag .= "<h4 style='word-wrap: break-word; width: 100%;'>PREITY COLLECTION</h4>";
                $printAllTag .= "<h6>SN: " . $listing -> product_id . "</h6>";

                $printAllTag .= "<h6>Price Code: " . $listing -> product_price_code . "</h6>";
                $printAllTag .= '<h6>Size: ' . $detail -> size . '</h6>';
                $printAllTag .= "<h6>Color: " . $detail -> color . "</h6>";
                $printAllTag .= "<h5>MPR: " . $listing -> selling_price . "</h5>";
                $printAllTag .= "<h6>Made in India</h6>";
                $printAllTag .= "<h6>Dry Clean Only</h6>";
                $printAllTag .= "</div>";
        }
    @endphp
    <x-button x-data @click="() => {
        let a = window.open('', '',);
        a.document.write(`
        <html>
            <head>
                <style>
                    *{
                        margin: 0px;
                        padding: 0px;
                    }
                    h4,h5,h6{
                        margin: 5px;
                    }
                </style>
            </head>
            <body>
                <div style='display:flex;'>
                    {{$printAllTag}}    
                </div>
            </body>
        </html>
        `);
        a.document.close();
        a.print();
    }">Print All Tag</x-button>
    <x-form.delete-button url="/listings/{{$listing->id}}" name="Delete listing"/>
    <x-form.container>
        <form action="/listings/{{$listing->id}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-form.field field="name" fieldName="Name" inputType="text" :value="$listing->name"> </x-form.field>
            <x-form.field field="description" fieldName="Description" inputType="text" :value="$listing->description"> </x-form.field>
            <x-form.field field="brand" fieldName="Brand" inputType="text" :value="$listing->brand"> </x-form.field>
            <x-form.field field="vendor" fieldName="Vendor" inputType="text" :value="$listing->vendor"> </x-form.field>
            <x-form.field field="initPrice" fieldName="Initial Price" inputType="number" :value="$listing->initPrice"> </x-form.field> 
            <x-button>Update listing</x-button>
        </form>
    </x-form.container>
    @foreach ($listing->details as $detail)
        <x-form.container>
            <form action="/details/{{$detail->id}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-form.field field="inventory" fieldName="Inventory" inputType="number" :value="$detail->inventory"> </x-form.field>
                <x-form.field field="sold" fieldName="Sold" inputType="number" :value="$detail->sold"> </x-form.field>
                <x-form.field field="weight" fieldName="Weight" inputType="number" :value="$detail->weight"> </x-form.field>
                <x-form.field field="size" fieldName="Size" inputType="text" :value="$detail->size"> </x-form.field>
                <x-form.field field="color" fieldName="Color" inputType="color" :value="$detail->color"> </x-form.field>
                <input name="images[]" type="file" multiple>
                <div class="flex ml-2 gap-2">
                    @foreach ($detail->images as $image)
                        @php
                            $imageURL = $image -> imageURL;
                            if(is_file($imageURL))
                                $imageURL = asset($imageURL); 
                        @endphp
                        <img src="{{$imageURL}}" alt="" class="w-40">
                    @endforeach
                </div>
            <x-button>Update detail</x-button>
            </form>
            <x-form.delete-button url="/details/{{$detail->id}}" name="Delete detail"/>
            <x-button x-data @click="() => {
                let a = window.open('', '',);
                    a.document.write(`
                    <html>
                        <head>
                            <style>
                                *{
                                    margin: 0px;
                                    padding: 0px;
                                }
                                h4,h5,h6{
                                    margin: 5px;
                                }
                            </style>
                        </head>
                        <body>
                        <div style='width:125px; display:flex; border-width:1px; border-style:solid;'>
                            <div style='width:100%'>
                                <h4 style='word-wrap: break-word;'>PREITY COLLECTION</h4>
                                <h6>SN: {{$listing -> product_id}}</h6>
                                <h6>Price Code: {{$listing -> product_price_code}}</h6>
                                <h6>Size: {{$detail -> size}}</h6>
                                <h6>Color: {{$detail -> color}}</h6>
                                <h5>MPR: ${{$listing -> selling_price}}</h5>
                                <h6>Made in India</h6>
                                <h6>Dry Clean Only</h6>
                            </div>
                        </div>
                        </body>
                    </html>
                `);
                a.document.close();
                a.print();
            }">Print tag</x-button>
        </x-form.container>
    @endforeach

    <form action="/details?listingId={{$listing->id}}" method="post">
        @csrf
        <x-button>Add new detail</x-button>
    </form>
</x-layout>