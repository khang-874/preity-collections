@props(['name'])
@if(request($name))
    <input type="hidden" name="{{$name}}" value="{{request($name)}}">
@endif
{{-- <div>{{request)}}</div> --}}