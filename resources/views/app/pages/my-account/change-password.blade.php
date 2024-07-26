@section('title', 'Change Password')
<x-app-guest-layout>
    <x-page-layout :props="['title' => 'Change Password']">
        <x-my-account-layout>
            <div class="px-5 mb-3 w-8/12">
                @include('app.profile.partials.update-password-form')
            </div>
        </x-my-account-layout>
    </x-page-layout>
</x-app-guest-layout>
