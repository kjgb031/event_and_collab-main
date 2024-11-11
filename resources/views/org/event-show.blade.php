@extends('layouts.app')

@section('title')
    Organization Dashboard
@endsection



@section('content')
    <main class="container mx-auto my-10">
        {{-- Page title --}}
        <section class="grid grid-cols-2 gap-4">
            <h1 class="text-3xl font-bold">
                Manage Event
            </h1>


        </section>

        <section class="my-6">
            @livewire('org.event-form', ['event' => $event])
        </section>
        <section class="my-6">
            @livewire('org.reserved-confirmation-table', ['event' => $event])
        </section>
        <section class="my-6">
            @livewire('org.appointments-table', ['event' => $event])
        </section>
        <section class="my-6">
            @livewire('org.attendance-table', ['event' => $event])
        </section>
        <section class="my-6">
            @livewire('org.feedback-table', ['event' => $event])
        </section>

    </main>
@endsection
