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
            <div class="flex justify-end gap-2">
                {{-- scan qr btn --}}
                <button id="scan-btn" class="btn btn-primary">
                    Scan QR
                </button>
                {{-- back btn --}}
                <a href="{{ route('organization.dashboard') }}" class="btn btn-primary">
                    Back
                </a>
            </div>
        </section>

        {{-- Scan QR Modal --}}
        <div id="scan-modal" class="fixed inset-0 z-10 hidden overflow-y-auto modal">
            {{-- Modal content --}}
            <div class="p-4 bg-white modal-content">
                <div id="qr-reader" class="w-full"></div>
                <button id="close-modal" class="mt-2 btn btn-secondary">Close</button>
            </div>
        </div>

        <div id="student-info" class="hidden">
            <h2 id="student-name"></h2>
            <p id="student-email"></p>
            <button id="mark-attended-btn" class="btn btn-primary">Mark as Attended</button>
        </div>

        <section class="my-6">
            @livewire('org.event-form', ['event' => $event])
        </section>


        <section class="my-6">
            @livewire('org.attendance-table', ['event' => $event])
        </section>
        <section class="my-6">
            @livewire('org.feedback-table', ['event' => $event])
        </section>

    </main>
@endsection

@push('scripts')
    {{-- Include QR code scanning library --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"
        integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let html5QrcodeScanner;

        document.getElementById('scan-btn').addEventListener('click', function() {
            // Open the modal
            document.getElementById('scan-modal').classList.remove('hidden');

            html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", {
                    fps: 10,
                    qrbox: 250
                });

            function onScanSuccess(decodedText, decodedResult) {
                // Send the scanned UID to the eventScan route
                fetch("{{ route('organization.event.scan', $event) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            uid: decodedText
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show the student information
                            document.getElementById('student-name').textContent = data.student.name;
                            document.getElementById('student-email').textContent = data.student.email;
                            document.getElementById('student-info').classList.remove('hidden');

                            // Add event listener to the mark as attended button
                            document.getElementById('mark-attended-btn').addEventListener('click', function() {
                                // Send the mark as attended request
                                fetch("{{ route('organization.event.mark-attended', $event) }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                        },
                                        body: JSON.stringify({
                                            uid: decodedText
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        alert(data.message);
                                        // Close the scanner
                                        html5QrcodeScanner.clear();
                                        document.getElementById('scan-modal').classList.add(
                                            'hidden');
                                    })
                                    .catch(error => {
                                        alert('An error occurred');
                                    });
                            });
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        alert('An error occurred');
                    });
            }

            function onScanError(errorMessage) {
                // handle scan error
                console.error(errorMessage);
                // Hide the student information
                document.getElementById('student-info').classList.add('hidden');
            }

            html5QrcodeScanner.render(onScanSuccess, onScanError);
        });

        document.getElementById('close-modal').addEventListener('click', function() {
            // Close the modal
            document.getElementById('scan-modal').classList.add('hidden');
            // Stop the scanner
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }
        });
    </script>
@endpush
