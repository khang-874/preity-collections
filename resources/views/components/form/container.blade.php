
@props(['actionURL', 'data' => '', 'formID' => 'form'])
<form   x-data="{{$data}}" action="{{$actionURL}}" method="post" enctype="multipart/form-data" id="{{$formID}}"
        class="py-6 px-6 mt-8 flex flex-col gap-4 bg-white mx-auto border-2">
    @csrf
    {{$slot}}
</form>