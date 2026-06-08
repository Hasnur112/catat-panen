<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CatatPanen</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#0f5132]">
            
            <div class="mb-4">
                <a href="/">
                    <h1 class="text-white text-3xl font-bold">CatatPanen</h1>
                </a>
            </div>

            {{ $slot }}
            
        </div>
    </body>
</html>