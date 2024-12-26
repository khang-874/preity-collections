@if(session() -> has('message'))
    <div 
        x-data="{show:true}"
        x-show="show"
        class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-50 flex items-start justify-center z-50"
        x-init="setTimeout(()=>show=false, 1500)" 
    >
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm mx-auto min-w-sm">
            <h2 class="text-xl font-semibold mb-4">Notification</h2>
            <p class="mb-4">{{session('message')}}</p>
        </div>
    </div>
@endif