<div class="w-full bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-2 rounded mb-4 flex items-center justify-center">
    <div class="flex items-center gap-3">
        <strong>Your email address is not verified.</strong> Please verify your email to access all features.
        <form method="POST" action="{{ route('app.verification.send') }}">
            @csrf
            <div>
                <button id="resend-button" class="underline text-blue-400 cursor-pointer">
                    {{ __('Verifica e-mail') }} <span id="countdown"></span>
                </button>
            </div>
        </form>
    </div>
</div>