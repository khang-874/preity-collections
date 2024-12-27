<div class="pl-2 flex items-center w-max">
    <button x-data @click="$store.showMenu.on = true" class="lg:hidden"><i class="fa-solid fa-bars fa-lg"></i></button>
    <a href="{{url('/')}}" class="flex gap-2 items-center">
        <img src="{{url('/')}}/images/logo_white.png" alt="Preity Collection Logo" class="h-12">
        <div class="lg:hidden flex flex-col text-left">
            <h1 class="leading-tight text-lg text-primary md:text-2xl font-bold">Preity</h1>
            <h1 class="leading-tight text-lg text-primary md:text-2xl font-bold">Collection</h1>
        </div>
        <h1 class="text-xl hidden lg:block text-primary md:text-2xl font-bold break-normal whitespace-normal leading-tight">
                Preity Collection
        </h1>

    </a>
</div> 