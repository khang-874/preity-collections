<form x-data="{
    disableSubmit: true, 
    inputText: null,
    handleClick(event){
        console.log(event);
        if(this.disableSubmit){
            event.preventDefault();
            $refs.input.focus();
        }else{
            $el.action = window.location.href;
            $el.submit();
        }
    }
}" action="/" class="h-full flex flex-col justify-center">
    <div class="flex gap-2 rounded-lg focus:shadow-md">
        <button @click="handleClick" class=""><i class="fa fa-search z-20 fa-lg"></i></button>
        <input
            x-ref="input"
            x-model="inputText"
            x-on:input="(inputText !== null || inputText.length != 0) ? disableSubmit = false : disableSubmit = true" 
            type="text"
            name="search"
            class="  w-0 text-black focus:w-24 focus:mr-2 focus:outline-none focus:pl-2 focus:border-2 focus:rounded-md"
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