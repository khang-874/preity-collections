@if (session() -> has('message'))
    <div    x-data="{show:true}" 
            x-show="show" 
            x-cloak
            class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-48 py-3" 
            x-init="setTimeout(()=>show=false, 1500)">
        <p>
            {{session('message')}} 
        </p>
    </div>
@endif