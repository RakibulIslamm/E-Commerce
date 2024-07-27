<div class="w-full flex items-start gap-5 overflow-hidden">
    <div class=" min-w-[200px] bg-slate-200 flex flex-col">
        <a class="px-6 py-3 {{ Request::is('account/summary') ? 'bg-slate-400 font-semibold text-white' : '' }} hover:bg-slate-400  hover:text-white transition-all ease-in-out"
            href="{{ route('app.summary') }}">Summary</a>
        <a class="px-6 py-3 {{ Request::is('account/orders') ? 'bg-slate-400 font-semibold text-white' : '' }} hover:bg-slate-400  hover:text-white transition-all ease-in-out"
            href="{{ route('app.account.orders') }}">My orders</a>
        <a class="px-6 py-3 {{ Request::is('account/my-data') ? 'bg-slate-400 font-semibold text-white' : '' }} hover:bg-slate-400  hover:text-white transition-all ease-in-out"
            href="{{ route('app.account.my-data') }}">Account</a>
        <a class="px-6 py-3 {{ Request::is('account/change-password') ? 'bg-slate-400 font-semibold text-white' : '' }} hover:bg-slate-400  hover:text-white transition-all ease-in-out"
            href="{{ route('app.account.change-password') }}">Change
            password</a>

    </div>
    <div class="w-[calc(100%_-_200px)]">
        {{ $slot }}
    </div>
</div>
