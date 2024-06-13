
@props(['actionURL', 'data' => '', 'formID' => 'form'])
<form   x-data="{{$data}}" action="{{$actionURL}}" method="post" enctype="multipart/form-data" id="{{$formID}}"
        {{$attributes -> merge(['class' => 'p-4 grid lg:grid-cols-2 gap-2'])}}>
    @csrf
    {{$slot}}
</form>