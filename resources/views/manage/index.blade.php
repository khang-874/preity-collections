@props(['categories'])
<x-layout>
    <header>
        <x-logo></x-logo>
        <x-navbar :categories="$categories"></x-navbar>
    </header>
    <main>
        <div class="mx-[10%] bg-white border drop-shadow-md p-3 mb-4 mt-6">
            <div>Categories: </div>
            @foreach ($categories as $category)
                <div class="flex items-center w-full">
                    <div class="flex-grow">{{$category -> name}}</div>
                    <x-form.delete-button url="/categories/{{$category->id}}" name="Delete"></x-form.delete-button> 
                </div>
            @endforeach
            <x-form.container actionURL="/categories" formId="createCategory">
                <x-form.field  inputType="text" field="name" fieldName="Enter new category name:" value=""></x-form>
                <x-button>Create new category</x-button>
            </x-form.container>
        </div>
        @php
            $categoryId = '';
            $sectionId = '';
            if(sizeof($categories) != 0){
                $categoryId = $categories -> first() -> id;
                    if(sizeof($categories -> first() -> sections) != 0)
                        $sectionId = $categories -> first() -> sections -> first() -> id;
            }
        @endphp
        <div x-data="{categoryId:'{{$categoryId}}'}"class="mx-[10%] bg-white border drop-shadow-md p-3 mb-4">
            <x-form.select-category :categories="$categories" selectId="categorySection"></x-form.select-category> 
            <div>Sections: </div>
            @foreach ($categories as $category)
                @foreach ($category->sections as $section)
                    <template x-if="categoryId == {{$section->category_id}}">
                        <div class="flex items-center w-full">
                            <div class="flex-grow">{{$section -> name}}</div>
                            <x-form.delete-button url="/sections/{{$section->id}}" name="Delete"></x-form.delete-button> 
                        </div>
                    </template>
                @endforeach 
            @endforeach
            <x-form.container actionURL="/sections" formId="createSection">
                <input type="hidden" name="categoryId" :value="categoryId">
                <x-form.field  inputType="text" field="name" fieldName="Enter new section name:" value=""></x-form>
                <x-button>Create new section</x-button>
            </x-form.container>
        </div>
        <div x-data="{
            categoryId : '{{$categoryId}}',
            sectionId: '{{$sectionId}}',
        }"class="mx-[10%] bg-white border drop-shadow-md p-3 mb-4">
            <div>
                <x-form.select-category :categories="$categories" selectId="categorySubsection"></x-form.select-category> 
                <x-form.select-section :categories="$categories"></x-form.select-section>            
                <div>Subsections: </div>
                @foreach ($categories as $category)
                    @foreach ($category->sections as $section)
                        @foreach ($section -> subsections as $subsection)
                                <div class="flex items-center w-full" x-show="sectionId == {{$subsection -> section_id}}">
                                    <div class="flex-grow">{{$subsection -> name}}</div>
                                    <x-form.delete-button url="/subsections/{{$subsection->id}}" name="Delete"></x-form.delete-button> 
                                </div>
                        @endforeach
                    @endforeach 
                @endforeach
            </div>
            <x-form.container actionURL="/subsections" formId="createSubsection">
                <input type="hidden" name="sectionId" :value="sectionId">
                <x-form.field  inputType="text" field="name" fieldName="Enter new subsection name:" value=""></x-form>
                <x-button>Create new subsection</x-button>
            </x-form.container>
        </div>

    </main>
</x-layout>