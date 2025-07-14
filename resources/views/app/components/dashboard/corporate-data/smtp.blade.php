<?php

$mail_host = null;
$mail_port = null;
$mail_username = null;
$mail_password = null;
$mail_from_address = null;
$secretary_email = null;

if (isset(tenant()?->smtp)) {
    $smtp = tenant()?->smtp;
    $mail_host = isset($smtp['mail_host']) ? $smtp['mail_host'] : null;
    $mail_port = isset($smtp['mail_port']) ? $smtp['mail_port'] : null;
    $mail_username = isset($smtp['mail_username']) ? $smtp['mail_username'] : null;
    $mail_password = isset($smtp['mail_password']) ? $smtp['mail_password'] : null;
    $mail_from_address = isset($smtp['mail_from_address']) ? $smtp['mail_from_address'] : null;
    $secretary_email = isset($smtp['secretary_email']) ? $smtp['secretary_email'] : null;
}

?>


<div id="smtp" class="w-full p-5 bg-white rounded-lg shadow border mt-4">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold pb-2">SMTP</h2>
        <button id="edit-smtp" class="px-5 py-1 border rounded">Edit</button>
    </div>
    <div class="mt-4 space-y-3 text-gray-700">
        <p><span class="font-semibold"> Mail Host:</span> {{ $mail_host ?? 'N/A' }}</p>
        <p><span class="font-semibold">Mail PORT:</span> {{ $mail_port ?? 'N/A' }}</p>
        <p><span class="font-semibold">Mail Username:</span> {{ $mail_username ?? 'N/A' }}</p>
        <p><span class="font-semibold">Mail Password:</span> {{ $mail_password ?? 'N/A' }}</p>
        <p><span class="font-semibold">Mail From:</span> 
            {{ $mail_from_address ?? 'N/A' }}
        </p>
    </div>
</div>
<div id="smtp-edit" class="w-full hidden p-5 bg-white rounded-lg shadow mt-4 border">
    <h2 class="text-xl font-semibold pb-2">Edit SMTP</h2>
    <form method="POST" action="{{ route('app.corporate-data.update-smtp') }}" class="w-full space-y-3">
        @method('PUT')
        @csrf
        <div class="w-full flex justify-between items-start gap-3">
            <div class="w-full">
                <label for="mail_host" class="block text-gray-700 text-sm font-bold mb-2">Mail Host</label>
                <input id="mail_host" name="mail_host" type="text" value="{{ old('mail_host', $mail_host ?? '') }}" 
                    placeholder="Ex: smtp.gmail.com"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="w-full">
                <label for="mail_port" class="block text-gray-700 text-sm font-bold mb-2">Mail PORT</label>
                <input id="mail_port" name="mail_port" type="text" value="{{ old('mail_port', $mail_port ?? '') }}"
                    placeholder="Ex: 587"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="w-full">
                <label for="mail_username" class="block text-gray-700 text-sm font-bold mb-2">Mail Username</label>
                <input id="mail_username" name="mail_username" type="text" value="{{ old('mail_username', $mail_username ?? '') }}"
                    placeholder="username"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
        </div>
        <div class="w-full flex justify-between items-start gap-3">
            <div class="w-4/12">
                <label for="mail_password" class="block text-gray-700 text-sm font-bold mb-2">Mail Password</label>
                <input id="mail_password" name="mail_password" type="text" value="{{ old('mail_password', $mail_password ?? '') }}" 
                    placeholder="password"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="w-4/12">
                <label for="mail_from_address" class="block text-gray-700 text-sm font-bold mb-2">Mail From</label>
                <input id="mail_from_address" name="mail_from_address" type="mail_from_address" value="{{ old('mail_from_address', $mail_from_address ?? '') }}" 
                    placeholder="example@gmail.com"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="w-4/12">
                <label for="secretary_email" class="block text-gray-700 text-sm font-bold mb-2">Secretary Email</label>
                <input id="secretary_email" name="secretary_email" type="secretary_email" value="{{ old('secretary_email', $secretary_email ?? '') }}" 
                    placeholder="example@gmail.com"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
        </div>
        <div class="flex justify-end gap-2">
            <button type="button" id="cancel-edit-smtp"
                class="px-5 py-1 border rounded bg-red-500 text-white">Cancel</button>
            <button type="submit" class="px-5 py-1 border rounded bg-sky-500 text-white">Aggiornamento</button>
        </div>
    </form>
</div>

<script type="module">
    commonUtils.element('edit-smtp').addEventListener('click', () => {
        commonUtils.toggleVisibility('smtp-edit', 'smtp', 'block');
    });

    commonUtils.element('cancel-edit-smtp').addEventListener('click', () => {
        commonUtils.toggleVisibility('smtp', 'smtp-edit', 'block');
    });
</script>
