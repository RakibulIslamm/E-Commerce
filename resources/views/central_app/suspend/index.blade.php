<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Suspended</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-8 max-w-md w-full text-center">
        <div class="text-red-500 mb-4 flex justify-center">
          <x-lucide-ban class="w-20 h-20" />
        </div>
        <h1 class="text-2xl font-semibold text-gray-800 mb-2">Sospeso</h1>
        <p class="text-gray-600 mb-6 text-lg">
          Questo sito è stato temporaneamente sospeso.
        </p>
        <div class="space-y-4">
            <a class="w-full bg-gray-100 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-200">
                Contact Support
            </a>
        </div>
    </div>
</body>
</html>
