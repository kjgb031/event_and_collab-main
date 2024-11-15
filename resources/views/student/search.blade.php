@extends('layouts.app')

@section('title')
    Search Results for {{ request('q') }}
@endsection

@section('content')

    <h1 class="my-10 text-4xl font-bold text-center">Search Results for "{{ request('q') }}"</h1>
    <section class="container grid grid-cols-1 gap-4 mx-auto my-10 md:grid-cols-2 lg:grid-cols-3">

        @if ($events->isEmpty())
            <div class="col-span-full min-h-96">
                <p class="w-full text-center text-gray-600">No events found for "{{ request('q') }}".</p>
            </div>
        @else
            @foreach ($events as $event)
                <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                    <img class="object-cover object-center w-full h-56" src="{{ $event->image }}" alt="{{ $event->name }}">

                    <div class="p-4">
                        <h2 class="text-xl font-bold text-gray-800">{{ $event->name }}</h2>
                        <p class="mt-2 text-gray-600">{{ $event->date->format('d M Y') }}</p>
                        <a href="{{ route('student.event.show', $event) }}" class="mt-4 btn btn-primary">View
                            Event</a>
                    </div>
                </div>
            @endforeach
        @endif
    </section>
@endsection
