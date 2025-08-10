{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title' | 'login')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <header class="bg-white dark:bg-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ config('app.name') }}</h1>
        </div>
    </header>

    <div class="flex min-h-[calc(100vh-5rem)]">
        <!-- Left side with background image -->
        <div class="hidden lg:block lg:w-1/2 relative">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1432821596592-e2c18b78144f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80');">
                <div class="absolute inset-0 bg-black/50"></div>
            </div>
            <div class="relative z-10 flex items-center justify-center h-full">
                <h2 class="text-4xl font-bold text-white text-center">Welcome Back</h2>
            </div>
        </div>

        <!-- Right side with login form -->
        @yield('contents')
    </div>
</body>
</html>
