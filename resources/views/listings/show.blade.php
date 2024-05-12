<x-layout>
@include('partials._navbar')
    <div class="mx-4">
        <x-card>
            <h4>{{$listing -> name}}</h4>
            @foreach ($listing->details as $detail)
                @foreach ($detail->images as  $image)
                   <div>
                        <img src="{{$image->imageURL}}"/>
                    </div> 
                @endforeach
            @endforeach
            <p>{{$listing -> description}}</p>
        </x-card>
    </div>
    <a href="/">Return</a>
</x-layout>