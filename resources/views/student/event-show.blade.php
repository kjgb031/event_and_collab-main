@extends('layouts.app')

@section('title')
    {{ $event->name }}
@endsection


@push('styles')
    <style>
        .rctxt {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .rctxt h1,
        .rctxt h2,
        .rctxt h3,
        .rctxt h4,
        .rctxt h5,
        .rctxt h6 {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1em;
        }

        .rctxt p {
            margin: 1em 0;
            font-size: 1.1rem;
            color: #555;
        }

        .rctxt a {
            color: #3498db;
            text-decoration: none;
        }

        .rctxt a:hover {
            text-decoration: underline;
        }

        .rctxt ul,
        .rctxt ol {
            padding-left: 1.5em;
            margin-bottom: 1.5em;
        }

        .rctxt li {
            margin-bottom: 0.5em;
            font-size: 1rem;
            color: #666;
        }

        .rctxt blockquote {
            font-style: italic;
            border-left: 4px solid #ddd;
            padding-left: 1em;
            margin-left: 0;
            margin-bottom: 1.5em;
            color: #555;
        }

        .rctxt strong {
            font-weight: bold;
            color: #e74c3c;
        }

        .rctxt em {
            font-style: italic;
            color: #16a085;
        }

        .rctxt code {
            font-family: 'Courier New', monospace;
            background-color: #f4f4f4;
            padding: 0.2em 0.4em;
            border-radius: 4px;
            color: #2c3e50;
        }

        .rctxt hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 2em 0;
        }

        .rctxt img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 1em 0;
        }
    </style>
@endpush


@section('content')
    <main class="container mx-auto my-10">
        <div class="flex justify-end">
            <a href="{{ route('student.dashboard') }}" class="m-4 btn btn-primary">
                Back
            </a>
        </div>
        @if (auth()->user()->isReservationConfirmed($event))
            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">You have successfully reserved a slot for this event.</span>
            </div>
        @elseif (auth()->user()->isReserved($event))
            <div class="relative px-4 py-3 mb-4 text-yellow-700 bg-yellow-100 border border-yellow-400 rounded"
                role="alert">
                <strong class="font-bold">Pending!</strong>
                <span class="block sm:inline">Your reservation is pending approval.</span>
            </div>
        @endif
        <div class="flex justify-end w-full">
            @livewire('event-action-buttons', ['event' => $event])
        </div>

        <article class="flex flex-col items-center gap-6">
            {{-- cover image --}}
            <img src="{{ \Storage::url($event->cover_image) }}" alt="{{ $event->name }}"
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
            <div class="mt-4 rctxt">
                {!! $event->description !!}
            </div>
        </article>
    </main>
@endsection
