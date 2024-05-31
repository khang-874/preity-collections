@props(['field', 'value', 'fieldName', 'inputType'])
<div class="p-4">
    <label for="{{$field}}">{{$fieldName}}</label>
    <input type="{{$inputType}}" name="{{$field}}" id="{{$field}}" value="{{$value}}" class="ml-2 border-2">
</div>