<div class="w-full flex items-start gap-5">
    <div class=" min-w-[200px] bg-slate-200 flex flex-col sticky top-20">
        <a class="px-6 py-3 {{ Request::is('account/summary') ? 'bg-slate-400 font-semibold text-white' : '' }} hover:bg-slate-400  hover:text-white transition-all ease-in-out"
            href="{{ route('app.summary') }}">Riepilogo</a>
        <a class="px-6 py-3 {{ Request::is('account/orders') ? 'bg-slate-400 font-semibold text-white' : '' }} hover:bg-slate-400  hover:text-white transition-all ease-in-out"
            href="{{ route('app.account.orders') }}">I miei ordini</a>
        <a class="px-6 py-3 {{ Request::is('account/my-data') ? 'bg-slate-400 font-semibold text-white' : '' }} hover:bg-slate-400  hover:text-white transition-all ease-in-out"
            href="{{ route('app.account.my-data') }}">Account</a>
        <a class="px-6 py-3 {{ Request::is('account/change-password') ? 'bg-slate-400 font-semibold text-white' : '' }} hover:bg-slate-400  hover:text-white transition-all ease-in-out"
            href="{{ route('app.account.change-password') }}">Cambio password</a>

    </div>
    <div class="w-[calc(100%_-_200px)] overflow-hidden">
        {{ $slot }}
    </div>
</div>
