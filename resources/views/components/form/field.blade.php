@props(['field', 'value' => '', 'fieldName', 'inputType' , 'divCss' => ''])

<div class="flex flex-col gap-1 {{$divCss}}">
    <label for="{{$field}}" class="flex-grow">{{$fieldName}}</label>
    <input type="{{$inputType}}" name="{{$field}}" id="{{$field}}" value="{{$value}}" class='border border-gray-600 rounded-md p-1' {{$attributes}}>
    @error('{{$field}}')
        <p class="text-red-500 mt-1">{{$message}}</p>
    @enderror
</div>