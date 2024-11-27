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
}" action="/listings" class="h-full lg:flex flex-col justify-center hidden">
    <div class="flex items-center border border-black rounded-md overflow-hidden focus:shadow-md">
        <input
            x-ref="input"
            x-model="inputText"
            x-on:input="(inputText.length != 0) ? disableSubmit = false : disableSubmit = true" 
            placeholder="Search Here"
            type="text"
            name="search"
            class="px-4 py-2 flex-grow outline-none w-24 lg:w-48"
        />
        <button @click="handleClick" class=""><i class="fa fa-search z-20 fa-lg mr-2"></i></button> 
        <x-form.retained-search-value name="category"></x-form.retained-search-value>
        <x-form.retained-search-value name="section"></x-form.retained-search-value>
        <x-form.retained-search-value name="subsection"></x-form.retained-search-value>
       
    </div>
</form>