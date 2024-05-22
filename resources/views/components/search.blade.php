<form action="/" class="h-full flex flex-col justify-center">
    <div class="relative border-2 rounded-lg focus:shadow-md">
        <div class="inline-block ml-4">
            <button
                type="submit"
            ><i
                class="fa fa-search z-20 "
            ></i>
            </button>
        </div>
        <input
            type="text"
            name="search"
            class="h-full ml-2 rounded-lg z-0 focus:outline-none text-black"
            placeholder="What are you looking for?"
        />
        {{-- <div class="absolute top-2 right-2">
            <button
                type="submit"
                class="h-10 w-20 text-white rounded-lg bg-red-500 hover:bg-red-600"
            >
                Search 
            </button>
        </div> --}}
    </div>
</form>