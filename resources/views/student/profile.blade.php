@extends('layouts.app')

@section('title')
    Profile
@endsection

@section('content')
<div class="container mx-auto">
    <div class="p-5 my-10 bg-white rounded-lg shadow-md">
        <div>
            <livewire:student-edit-form />
        </div>
    </div>
</div>
@endsection
