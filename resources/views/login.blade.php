@extends('layouts.guest')
{{-- capitalize $role + login --}}
@section('title')
    {{ strtoupper($role) }} Login
@endsection

@section('content')
    <main class="container flex items-center justify-center min-h-screen mx-auto">
        <div class="flex flex-col items-center justify-center max-w-md px-6 py-12 mx-auto bg-white rounded shadow-md">
            <h1 class="mb-8 text-2xl font-bold text-center">{{ ucfirst($role) }} </h1>
            <img src="/logo.png" alt="Student organization collaboration and events management">
            <form class="w-full mt-8" method="POST" action="{{ route('authenticate') }}">
                @csrf
                @method('POST')
                @if ($errors->any())
                    <div class="w-full mb-4">
                        <ul class="text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <x-text-input name="email" label="Email" type="email" required />
                <x-text-input name="password" label="Password" type="password" required />
                <x-primary-button class="w-full" type="submit">Login</x-primary-button>
            </form>

            @if ($role == 'student')
                <div class="mt-4">
                    Don&apos;t have an account? <a href="{{ route('student.register') }}" class="font-bold">Register</a>
                </div>
            @endif
        </div>


    </main>
@endsection
