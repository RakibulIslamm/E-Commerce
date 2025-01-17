<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="max-w-md text-center bg-white p-8 shadow-lg rounded-lg">
      <div class="text-red-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 4h.01m6.938-7.482a9 9 0 11-13.856 0m13.856 0L12 3m0 0L5.062 9.518" />
          </svg>
      </div>
      <h1 class="text-4xl font-bold text-gray-800 mt-4">500</h1>
      <p class="text-gray-600 mt-2">Oops! Something went wrong on our end. Please try again later.</p>
      <button class="mt-6 inline-block px-6 py-3 text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition duration-300">
          Submit a ticket
      </button>
  </div>
</body>
</html>