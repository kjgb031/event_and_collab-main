@extends('layouts.app')

@section('title')
    {{ $organization->name }}
@endsection


@section('content')
    <main class="container mx-auto my-10">
        <h1 class="text-4xl font-bold">
            {{ $organization->organization_name }}
        </h1>

        {{-- render all approved events by this org --}}
        <div class="grid grid-cols-1 gap-4 my-10 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($organization->events as $event)
                <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                    <img class="object-cover object-center w-full h-56" src="{{ $event->image }}" alt="{{ $event->name }}">

                    <div class="p-4">
                        <h2 class="text-xl font-bold text-gray-800">{{ $event->name }}</h2>
                        <p class="mt-2 text-gray-600">{{ $event->date->format('d M Y') }}</p>
                        <a href="{{ route('student.event.show', $event) }}"
                            class="mt-4 btn btn-primary">View
                            Event</a>
                    </div>
                </div>
            @endforeach
        </div>


    </main>
@endsection
