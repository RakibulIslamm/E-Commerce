<div class="w-full flex items-start gap-5 overflow-hidden">
    <div class=" min-w-[200px] bg-slate-200 flex flex-col">
        <a class="px-6 py-3 {{ Request::is('account') ? 'bg-slate-400 font-semibold text-white' : '' }} hover:bg-slate-400 hover:font-semibold hover:text-white transition-all ease-in-out"
            href="{{ route('app.account') }}">Account</a>
        <a class="px-6 py-3 {{ Request::is('account/orders') ? 'bg-slate-400 font-semibold text-white' : '' }} hover:bg-slate-400 hover:font-semibold hover:text-white transition-all ease-in-out"
            href="{{ route('app.account.orders') }}">My orders</a>
        <a class="px-6 py-3 {{ Request::is('account/billing') ? 'bg-slate-400 font-semibold text-white' : '' }} hover:bg-slate-400 hover:font-semibold hover:text-white transition-all ease-in-out"
            href="{{ route('app.account.billing') }}">Billing
            address</a>
        <a class="px-6 py-3 {{ Request::is('account/change-password') ? 'bg-slate-400 font-semibold text-white' : '' }} hover:bg-slate-400 hover:font-semibold hover:text-white transition-all ease-in-out"
            href="{{ route('app.account.change-password') }}">Change
            password</a>

    </div>
    <div class="w-[calc(100%_-_200px)]">
        {{ $slot }}
    </div>
</div>
