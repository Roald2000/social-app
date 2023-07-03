<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'App')</title>
    @vite('./resources/css/app.css')
</head>

<body>
    <header class="p-3 w-full z-50 sticky top-0 left-0 backdrop-blur-md">
        <nav class="container mx-auto flex flex-row gap-2 justify-between items-center z-50">
            <a class="w-fit text-xl font-bold" href="/">App</a>
            <div id="navbtn"
                class="group/user relative p-2 rounded border-2 border-blue-600 text-blue-700 hover:bg-blue-600 hover:text-white cursor-pointer">
                <span class=" max-w-[150px] text-ellipsis line-clamp-1">
                    @auth
                        {{ auth()->user()->email }}
                    @else
                        Get Started
                    @endauth
                </span>
                <ul id="nav_content" class="hidden absolute left-0 top-[115%] py-1 w-full rounded bg-blue-400 z-50">
                    @auth
                        <li>
                            <a class="inline-flex w-full hover:bg-slate-300 px-2"
                                href="{{ route('user.profile') }}">Profile</a>
                        </li>
                        <li>
                            <a class="text-red-600 inline-flex w-full hover:bg-slate-300 px-2"
                                href="{{ route('logout') }}">Logout</a>
                        </li>
                    @else
                        <li> <a class="w-full inline-block hover:bg-slate-300 px-2"
                                href="{{ route('view.login') }}">Login</a>
                        </li>
                        <li>
                            <a class="w-full inline-block hover:bg-slate-300 px-2"
                                href="{{ route('view.register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </header>
    <main class="container mx-auto p-3">
        @yield('content')
    </main>
    @vite('./resources/js/app.js')
    @stack('scripts')
</body>

</html>
