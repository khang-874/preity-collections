<div class="w-full flex justify-center mb-2">
    @if (request('category'))
    @php
        $categoryName= \App\Models\Category::find(request('category')) -> name
    @endphp
        <p class="text-lg font-medium">{{$categoryName}}</p>
    @endif
    @if (request('section'))
    @php
        $sectionName = \App\Models\Section::find(request('section')) -> name
    @endphp
        <p class="text-lg font-medium">{{$sectionName}}</p>
    @endif
    @if (request('subsection'))
    @php
        $subsectionName = \App\Models\Subsection::find(request('subsection')) -> name
    @endphp
        <p class="text-lg font-medium">{{$subsectionName}}</p>
    @endif
</div>
