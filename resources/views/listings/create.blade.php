<x-layout>
    <main>
        <div>
            this is a form to create new listing
        </div>
        <form action="/listings" method="post" enctype="multipart/form-data" class="p-2">
            @csrf
            <div class="mb-6">
                <label for="name">name</label>
                <input type="text" name="name" class='border border-gray-600'>
            </div>
            <div class="mb-6">
                <label for="description">description</label>
                <input type="text" name="description" class='border border-gray-600'>
            </div>
            <div class="mb-6">
                <label for="brand">brand</label>
                <input type="text" name="brand" class='border border-gray-600'>
            </div>
            <div class="mb-6">
                <label for="vendor">vendor</label>
                <input type="text" name="vendor" class='border border-gray-600'>
            </div>
            <div class="mb-6">
                <label for="initPrice">Initial price</label>
                <input type="number" step = "0.01" name="initPrice" class='border border-gray-600'>
            </div>
            <div class="mb-6">
                <label for="color">color</label>
                <input type="color" name="color" class='border border-gray-600'>
            </div>
            <div class="mb-6">
                <label for="size">size</label>
                <input type="text" name="size" class='border border-gray-600'>
            </div>
            <div class="mb-6">
                <label for="inventory">inventory</label>
                <input type="number" name="inventory" class='border border-gray-600'>
            </div>
            <div class="mb-6">
                <label for="sold">sold</label>
                <input type="number" name="sold" class='border border-gray-600'>
            </div>
            <div class="mb-6">
                <label for="weight">weight</label>
                <input type="number" step="0.01" name="weight" class='border border-gray-600'>
            </div>
            <div class="mb-6">
                <label for="images">images</label>
                <input type="file" name="images[]" class='border border-gray-600' multiple>
            </div>
            <div class="mb-6">
                <button class="border border-gray-500">Create new listing</button>
                <a href="/" class="mx-6 border border-gray-600">Back</a>
            </div>
        </form>
    </main>
</x-layout>