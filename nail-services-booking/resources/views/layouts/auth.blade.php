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
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Your Company Name</h1>
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
{{--        <div class="w-full lg:w-1/2 flex items-center justify-center px-4">--}}
{{--            <div class="max-w-md w-full space-y-8 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">--}}
{{--                <div>--}}
{{--                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">--}}
{{--                        Sign in to your account--}}
{{--                    </h2>--}}
{{--                    @if ($errors->any())--}}
{{--                        <div class="mt-4">--}}
{{--                            @foreach ($errors->all() as $error)--}}
{{--                                <div class="bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 rounded-md p-4 my-2">--}}
{{--                                    <div class="flex">--}}
{{--                                        <div class="flex-shrink-0">--}}
{{--                                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">--}}
{{--                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>--}}
{{--                                            </svg>--}}
{{--                                        </div>--}}
{{--                                        <div class="ml-3">--}}
{{--                                            <p class="text-sm text-red-700 dark:text-red-200">{{ $error }}</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--                <form class="mt-8 space-y-6" action="{{ route('authenticateUser') }}" method="POST">--}}
{{--                    @csrf--}}
{{--                    <div class="rounded-md shadow-sm -space-y-10px">--}}
{{--                        <div>--}}
{{--                            <label for="username" class="sr-only">Username</label>--}}
{{--                            <input id="username" name="username" type="text" required--}}
{{--                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm dark:bg-gray-700"--}}
{{--                                placeholder="Username">--}}
{{--                        </div>--}}
{{--                        <div class="my-4">--}}
{{--                            <label for="password" class="sr-only">Password</label>--}}
{{--                            <input id="password" name="password" type="password" required--}}
{{--                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm dark:bg-gray-700"--}}
{{--                                placeholder="Password">--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="flex items-center justify-between">--}}
{{--                        <div class="flex items-center">--}}
{{--                            <input id="remember_me" name="remember" type="checkbox"--}}
{{--                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:border-gray-700 dark:bg-gray-700">--}}
{{--                            <label for="remember_me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">--}}
{{--                                Remember me--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <button type="submit"--}}
{{--                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">--}}
{{--                            Sign in--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</body>
</html>
