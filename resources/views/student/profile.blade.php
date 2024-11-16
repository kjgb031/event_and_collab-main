@extends('layouts.app')

@section('title')
    Profile
@endsection

@section('content')
<div class="container mx-auto">
    <div class="p-5 my-10 bg-white rounded-lg shadow-md">
        <div>
            <div class="flex items-center justify-end">
                <a href="{{ route('student.dashboard') }}" class="mb-4 btn btn-primary">Back</a>
            </div>
            <livewire:student-edit-form />
        </div>
    </div>
</div>
@endsection
