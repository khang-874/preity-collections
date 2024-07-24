@props(['categories'])

<div class="sticky inset-0 z-20">
    <x-logo></x-logo>
    <x-navbar-large :categories="$categories"></x-navbar-large>
</div>
<x-cart></x-cart>
<x-navbar :categories="$categories"></x-navbar>
