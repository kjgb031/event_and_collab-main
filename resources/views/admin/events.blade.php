@extends('layouts.app')

@section('title')
    Manage Events
@endsection



@section('content')
    <main class="container mx-auto my-10">
        {{-- Page title --}}
        <section class="grid grid-cols-2 gap-4">
            <h1 class="text-3xl font-bold">
                Manage Events
            </h1>

            {{-- Action buttons
            <div class="flex justify-end gap-6">
                <a href="#" class="btn btn-primary">
                    Manage Organization
                </a>
                <a href="#" class="btn btn-primary">
                    Manage Events
                </a>
            </div> --}}
        </section>

        <section class="my-6">
            @livewire('events-table')
        </section>
    </main>
@endsection
