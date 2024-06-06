
@props(['actionURL', 'categoryId' => '', 'subsectionId' => '', 'sectionId' => ''])
<form   x-data="{
            categoryId: '{{$categoryId}}',
            sectionId: '{{$sectionId}}',
            subsectionId: '{{$subsectionId}}'
        }" action="{{$actionURL}}" method="post" enctype="multipart/form-data" id="form"
        class="py-6 px-6 mt-8 flex flex-col gap-4 w-[80%] bg-white mx-auto border-2">
    {{$slot}}
</form>