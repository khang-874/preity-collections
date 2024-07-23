<form x-data="{
    inputText: '',
    handleClick(event){
        if(this.inputText.length == 0){
            event.preventDefault();
            $refs.input.focus();
        }else{
            $el.submit();
        }
    }
}" action="/listings" class="h-full flex flex-col justify-center">
    <div class="flex gap-2 rounded-lg focus:shadow-md">
        <button @click="handleClick" class=""><i class="fa fa-search z-20 fa-lg"></i></button>
        <input
            x-ref="input"
            x-model="inputText"
            x-on:input="(inputText.length != 0) ? disableSubmit = false : disableSubmit = true" 
            {{-- x-on:change="(inputText.length == 0) ? $refs.input.blur() : $refs.input.focus()" --}}
            placeholder="Search"
            type="text"
            name="search"
            class="w-0 text-black md:w-56 md:pl-2 md:outline-none md:border-2 md:rounded-md md:focus:w-56 focus:w-24 focus:outline-none focus:pl-2 focus:border-2 focus:rounded-md"
            :class="inputText.length != 0 ? 'w-24 outline-none pl-2 border-2 rounded-md' : ''"
        />
        <x-form.retained-search-value name="category"></x-form.retained-search-value>
        <x-form.retained-search-value name="section"></x-form.retained-search-value>
        <x-form.retained-search-value name="subsection"></x-form.retained-search-value>
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