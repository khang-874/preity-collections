@props(['type'])
<form x-data="{
        handleClick(){
            $el.action = window.location.href;
            $el.submit();
        }
    }" method="get" action="/"> 

    <x-form.retained-search-value name="category"></x-form.retained-search-value> 
    <x-form.retained-search-value name="section"></x-form.retained-search-value> 
    <x-form.retained-search-value name="subsection"></x-form.retained-search-value> 
    @if($type != 'size')
        <x-form.retained-search-value name="size"></x-form.retained-search-value> 
    @endif
    @if($type != 'color')
        <x-form.retained-search-value name="color"></x-form.retained-search-value> 
    @endif

   {{$slot}} 
</form>
