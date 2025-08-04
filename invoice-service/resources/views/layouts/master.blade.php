<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
{{--    <div class="drawer lg:drawer-open">--}}
{{--        <input id="my-drawer" type="checkbox" class="drawer-toggle" />--}}
{{--        <div class="drawer-content">--}}
{{--            <!-- Page content here -->--}}
{{--            <label for="my-drawer" class="btn btn-primary drawer-button show lg:hidden">Open drawer</label>--}}
{{--            <div class="navbar bg-base-100 shadow-sm show lg:hidden">--}}
{{--                <div class="flex-1">--}}
{{--                    <a class="btn btn-ghost text-xl">daisyUI</a>--}}
{{--                </div>--}}
{{--                <div class="flex-none">--}}
{{--                    <button for="my-drawer" class="btn btn-square btn-ghost drawer-button">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-5 w-5 stroke-current"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path> </svg>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="drawer-side">--}}
{{--            <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>--}}
{{--            <ul class="menu bg-base-200 text-base-content min-h-full w-80 p-4">--}}
{{--                <!-- Sidebar content here -->--}}
{{--                <li><a>Sidebar Item 1</a></li>--}}
{{--                <li><a>Sidebar Item 2</a></li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
<div class="drawer">
    <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col">
        <!-- Navbar -->
        <div class="navbar bg-base-300 w-full">
            <div class="flex-none lg:hidden">
                <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        class="inline-block h-6 w-6 stroke-current"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        ></path>
                    </svg>
                </label>
            </div>
            <div class="flex-1">
                <a href="{{ route('dashboard') }}" class="text-xl cursor-pointer">daisyUI</a>
            </div>
            <div class="flex gap-2">
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full ">
                            <img
                                alt="Tailwind CSS Navbar component"
                                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                        </div>

                    </div>
                    <ul
                        tabindex="0"
                        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                        <li>
                            <h3 class="justify-between">
                                {{ session()->get('user')['name'] }}
                            </h3>
                        </li>
                        <li><a href="route('logout')">Logout</a></li>
                    </ul>
                </div>
            </div>
{{--            <div class="mx-2 flex-1 px-2">Navbar Title</div>--}}
{{--            <div class="hidden flex-none lg:block">--}}
{{--                <ul class="menu menu-horizontal">--}}
{{--                    <!-- Navbar menu content here -->--}}
{{--                    <li><a>Navbar Item 1</a></li>--}}
{{--                    <li><a>Navbar Item 2</a></li>--}}
{{--                </ul>--}}
{{--            </div>--}}
        </div>
        <!-- Page content here -->
        <div class="w-[95vw] lg:w-[80vw] mx-auto mt-[10dvh] flex flex-row gap-2">

            <div class="w-1/4 hidden lg:block">
                <ul class="menu bg-base-200 min-h-full w-80 p-4">
                    <!-- Sidebar content here -->
                    @include('layouts._sidebar')
                </ul>
            </div>

            <div class="w-3/4">
                @yield('contents')
            </div>
        </div>

    </div>
    <div class="drawer-side">
        <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label>
        <ul class="menu bg-base-200 min-h-full w-80 p-4">
            <!-- Sidebar content here -->
            @include('layouts._sidebar')
        </ul>
    </div>
</div>
</body>
</html>
