@props(['name', 'type' => 'text', 'label'])
<div>
    <label class="block text-sm font-medium text-gray-600">{{$label}}</label>
    <input
        type="text"
        placeholder="{{$label}}"
        name="{{$name}}"
        class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-600"
    />
</div>