<x-central-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('app.verification.send') }}">
            @csrf

            <div>
                <x-primary-button id="resend-button" class=" disabled:bg-opacity-70 disabled:cursor-not-allowed">
                    {{ __('Resend Verification Email') }} <span id="countdown"></span>
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('app.logout') }}">
            @csrf

            <button type="submit"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>

    <script>
        // document.addEventListener('DOMContentLoaded', () => {
        //     const button = document.getElementById('resend-button');
        //     let remainingTime = 30;

        //     // Initialize button text
        //     button.textContent = `Resend Verification Email (${remainingTime}s)`;

        //     const interval = setInterval(() => {
        //         remainingTime -= 1;
        //         // countdown.textContent = `(${remainingTime}s)`;

        //         // Update button text with countdown
        //         button.textContent = `Resend Verification Email (${remainingTime}s)`;

        //         if (remainingTime <= 0) {
        //             clearInterval(interval);
        //             button.disabled = false;
        //             button.textContent = 'Resend Verification Email';
        //         }
        //     }, 1000); // Update every second

        //     // Disable the button for the initial 60 seconds
        //     setTimeout(() => {
        //         button.disabled = false;
        //     }, 30000); // 60 seconds
        // });
    </script>
</x-central-guest-layout>
