<div class="flex flex-col gap-1">
    <label for="counterInput" class="pl-1 text-sm text-slate-700 dark:text-slate-300">Items(s)</label>
    <div @dblclick.prevent class="flex items-center">
        <button @click="currentVal = Math.max(minVal, currentVal - incrementAmount)" class="flex h-10 items-center justify-center rounded-l-xl border border-slate-300 bg-slate-100 px-4 py-2 text-slate-700 hover:opacity-75 focus-visible:z-10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 active:opacity-100 active:outline-offset-0 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:focus-visible:outline-blue-600" aria-label="subtract">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/>
            </svg>
        </button>
        <input x-model="currentVal.toFixed(decimalPoints)" id="counterInput" type="text" class="border-x-none h-10 w-20 rounded-none border-y border-slate-300 bg-slate-100/50 text-center text-black focus-visible:z-10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-700 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus-visible:outline-blue-600" readonly />
        <button @click="currentVal = currentVal + incrementAmount" class="flex h-10 items-center justify-center rounded-r-xl border border-slate-300 bg-slate-100 px-4 py-2 text-slate-700 hover:opacity-75 focus-visible:z-10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 active:opacity-100 active:outline-offset-0 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:focus-visible:outline-blue-600" aria-label="add">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
        </button>
    </div>
</div>