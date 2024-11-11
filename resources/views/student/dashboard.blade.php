@extends('layouts.app')

@section('title')
    Student Dashboard
@endsection



@section('content')
    <main class="container mx-auto my-10">
        {{-- carousel --}}
        <section>
            <div class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($events as $event)
                            <li class="flex items-center justify-center splide__slide">
                                <img src="{{Storage::url($event->cover_image)}}"
                                alt="{{ $event->title }}" class="object-cover w-full h-96">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
        {{-- latest events --}}
        <section class="my-10">
            <h2 class="my-6 text-2xl font-bold">Latest Events</h2>
            <div class="grid grid-cols-3 gap-4">
                @foreach ($events as $event)
                <a href="{{ route('student.event.show', $event) }}">
                    <div class="p-4 text-center transition-transform duration-300 ease-in-out bg-white rounded-lg shadow hover:scale-105">
                        <img src="{{Storage::url($event->cover_image)}}" alt="{{ $event->title }}" class="object-cover w-full h-48">
                        <h3 class="mt-2 text-xl font-bold">{{ $event->name }}</h3>
                        <p class="text-gray-500">{{ $event->date->format('M d, Y') }}</p>
                        
                    </div>
                </a>
                @endforeach
            </div>
            
            <div class="flex items-center justify-center mt-6">
                <a href="{{route('student.events')}}" class="btn btn-primary">
                    View All 
                </a>
            </div>

        </section>

        {{-- 8 organizations --}}
        <section class="my-10">
            <h2 class="my-6 text-2xl font-bold">Organizations</h2>
            <div class="grid grid-cols-4 gap-4">
                @foreach ($organizations as $organization)
                <a href="{{ route('student.organization.show', $organization) }}">
                    <div class="p-4 transition-all duration-300 ease-in-out bg-white rounded-lg shadow hover:scale-105">
                        <img src="{{Storage::url($organization->avatar)}}" alt="{{ $organization->name }}" class="object-contain w-full h-48">
                        <h3 class="mt-2 text-xl font-bold text-center">{{ $organization->name }}</h3>
                       
                    </div>
                @endforeach
            </div>

            <div class="flex items-center justify-center mt-6">
                <a href="{{route('student.organizations')}}" class="btn btn-primary">
                    View All 
                </a>
            </div>
        </section>
        
    </main>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Splide('.splide', {
            type: 'fade',
            perPage: 1,
            autoplay: true,
            interval: 5000,
            pauseOnHover: false,
        }).mount();
    });
</script>