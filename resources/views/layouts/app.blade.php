<!DOCTYPE html>
<html lang="en">

@php
    $events = \App\Models\Event::all();
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>@yield('title')</title>
    @filamentStyles
    @vite('resources/css/app.css')
    @stack('styles')
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="antialiased">
    <header class="bg-white shadow" >
        <div class="container flex items-center justify-between py-2 mx-auto">
            <img src="/logo.png" class="object-contain w-44" alt="">

            {{-- search bar --}}
            @if (auth()->user()->role == 'student')

                <form action="{{ route('student.search') }}" method="GET" class="flex items-center">
                    <input type="text" name="q" class="px-4 py-2 border border-gray-200 rounded-lg"
                        placeholder="Search..." list="event-suggestions">
                    <datalist id="event-suggestions">
                        @foreach ($events as $event)
                            <option value="{{ $event->name }}"></option>
                        @endforeach
                    </datalist>
                    <button type="submit" class="px-4 py-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </form>
            @endif

            {{-- buttons --}}
            <div class="flex items-center space-x-6">
                {{-- notifications --}}
                @livewire('database-notifications')
                {{-- profile --}}

                @if (auth()->user()->role == 'student')
                <a href="{{ route('student.profile') }}" class="">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>

                </a>
                @endif


                {{-- logout --}}
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </header>

    @yield('content')

    <x-footer />
    @livewire('notifications')

    @filamentScripts
    @vite('resources/js/app.js')
    @stack('scripts')
</body>

</html>
