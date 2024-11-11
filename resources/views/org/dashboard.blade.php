@extends('layouts.app')

@section('title')
    Organization Dashboard
@endsection



@section('content')
    <main class="container mx-auto my-10">
        {{-- Page title --}}
        <section class="grid grid-cols-2 gap-4">
            <h1 class="text-3xl font-bold">
                {{ Auth::user()->organization_name }}'s Dashboard
            </h1>

        
        </section>

        <section class="my-6">
            @livewire('my-events-table')
        </section>
    </main>
@endsection
