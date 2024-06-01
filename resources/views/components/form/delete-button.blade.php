@props(['url', 'name'])

<form action="{{$url}}" method="post">
    @csrf
    @method("delete")
    <x-button class="bg-red-500">{{$name}}</x-button>
</form>
