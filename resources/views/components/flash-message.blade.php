@if(Session::has('message'))
    <div 
        x-data="{show:true}"
        x-show="show"
        class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-50 flex items-start justify-center z-50"
        x-init="setTimeout(()=>show=false, 1500)" 
    >
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm mx-auto min-w-sm">
            <h2 class="text-xl font-semibold mb-4">Notification</h2>
            <p class="mb-4">{{Session::get('message')}}</p>
        </div>
    </div>
@endif
<div 
    x-data="{
        message : 'ABCD',
    }"
    {{-- x-cloak --}}
    class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-50 items-center hidden justify-center z-50"
    @notification.window="() => {
        this.message = $event.detail.message;
        $el.classList.remove('hidden');
        $el.classList.add('flex');
        $el.children[0].children[1].innerText = this.message;
        setTimeout(() => {
            $el.classList.add('hidden');
            $el.classList.remove('flex');
        }, 2500)
    }" 
    @click="()=>{$el.classList.add('hidden'); $el.classList.remove('flex');}"
>
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm mx-auto min-w-sm flex justify-center flex-col">
        <h2 class="text-xl font-semibold mb-4">Notification</h2>
        <p class="mb-4" x-text="$root.message"></p>
    </div>
</div>