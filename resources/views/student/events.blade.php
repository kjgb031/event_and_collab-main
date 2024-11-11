@extends('layouts.app')

@section('title')
    Show all events
@endsection



@section('content')
    <main class="container mx-auto my-10">
        <h1 class="text-4xl font-bold">
            All Events
        </h1>


        <div id="calendar" class="max-w-3xl mx-auto my-10"></div>

    </main>
@endsection

{{-- full calendar --}}
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '{{ route('student.event.query') }}',
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    window.location.href = info.event.url;
                }
            });

            calendar.render();
        });
    </script>
@endpush
