@extends('layouts.app')

@section('title')
    Show all organizations
@endsection

@section('content')
    <div class="container px-4 py-20 mx-auto">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($organizations as $organization)
            <a href="{{ route('student.organization.show', $organization) }}">
                <div class="overflow-hidden transition-transform bg-white rounded-lg shadow-md hover:scale-105">
                    <img src="{{ $organization->avatar }}" class="object-cover w-full h-48" alt="{{ $organization->name }}">
                    <div class="p-4">
                        <h5 class="text-lg font-semibold">{{ $organization->name }}</h5>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
@endsection


