@extends('layouts.app')

@section('title')
    {{ $event->name }}
@endsection



@section('content')
    <main class="container mx-auto my-10">
        @if (auth()->user()->isReservationConfirmed($event))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">You have successfully reserved a slot for this event.</span>
            </div>
        @elseif (auth()->user()->isReserved($event))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Pending!</strong>
                <span class="block sm:inline">Your reservation is pending approval.</span>
            </div>
        @endif
        <div class="flex justify-end w-full">
            @livewire('event-action-buttons', ['event' => $event])
        </div>

        <article class="flex flex-col items-center gap-6">
            {{-- cover image --}}
            <img src="{{ $event->cover_url }}" alt="{{ $event->name }}"
                class="object-contain w-full rounded-lg shadow-lg h-96">

            {{-- event details --}}
            <h1 class="text-4xl font-bold">
                {{ $event->name }}
            </h1>
            <div class="text-center text-gray-600">
                <div class="flex items-center justify-center gap-2 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    {{ $event->location }}
                </div>
                {{ $event->date->format('F j, Y') }} <br>
                {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} -
                {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }} <br>


                By: {{ $event->user->organization_name }}


            </div>
            <div class="mt-4">
                {!! $event->description !!}
            </div>
        </article>
    </main>
@endsection
